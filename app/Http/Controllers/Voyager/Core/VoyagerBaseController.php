<?php

namespace App\Http\Controllers\Voyager\Core;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;
use TCG\Voyager\Models\DataType;

class VoyagerBaseController extends BaseVoyagerBaseController
{
    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];

        $searchNames = [];
        if ($dataType->server_side) {
            $searchable = SchemaManager::describeTable(app($dataType->model_name)->getTable())->pluck('name')->toArray();
            $dataRow = Voyager::model('DataRow')->whereDataTypeId($dataType->id)->get();
            foreach ($searchable as $key => $value) {
                $displayName = $dataRow->where('field', $value)->first()->getTranslatedAttribute('display_name');
                $searchNames[$value] = $displayName ?: ucwords(str_replace('_', ' ', $value));
            }
        }

        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', $dataType->order_direction);
        $usesSoftDeletes = false;
        $showSoftDeleted = false;

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
                $query = $model->{$dataType->scope}();
            } else {
                $query = $model::select("{$model->getTable()}.*");
            }

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model)) && Auth::user()->can('delete', app($dataType->model_name))) {
                $usesSoftDeletes = true;

                if ($request->get('showSoftDeleted')) {
                    $showSoftDeleted = true;
                    $query = $query->withTrashed();
                }
            }

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $search_key = $search->key;
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%'.$search->value.'%';
                $relationField = $this->findRelationField($dataType, $search_key);
                if(is_array($relationField)) {
                    $relationTable = "{$relationField['table']} AS {$relationField['table']}_relation";
                    if(!collect($query->getQuery()->joins)->pluck('table')->contains($relationTable)) {
                        $query->{$relationField['join']}("{$relationField['table']} AS {$relationField['asTable']}", "{$model->getTable()}.{$relationField['foreign_key']}", "=", "{$relationField['asTable']}.{$relationField['key']}");
                    }
                    $query->where("{$relationField['asTable']}.{$relationField['label']}", $search_filter, $search_value);

                } else {
                    $query->where($search_key, $search_filter, $search_value);
                }
            }

            if ($orderBy) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                $relationField = $this->findRelationField($dataType, $orderBy);
                if(in_array($orderBy, $dataType->fields())) {
                    $dataTypeContent = call_user_func([
                        $query->orderBy($orderBy, $querySortOrder),
                        $getter,
                    ]);
                } else if (is_array($relationField)) {
                    $relationTable = "{$relationField['table']} AS {$relationField['table']}_relation";
                    if(!collect($query->getQuery()->joins)->pluck('table')->contains($relationTable)) {
                        $query->{$relationField['join']}("{$relationField['table']} AS {$relationField['asTable']}", "{$model->getTable()}.{$relationField['foreign_key']}", "=", "{$relationField['asTable']}.{$relationField['key']}");
                    }
                    $dataTypeContent = call_user_func([
                        $query->orderBy("{$relationField['asTable']}.{$relationField['label']}", $querySortOrder),
                        $getter,
                    ]);
                } else {
                    $dataTypeContent = call_user_func([$query->latest($query->getQuery()->from .".". $model::CREATED_AT), $getter]);
                }
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($query->getQuery()->from .".". $model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($query->getQuery()->from .".".$model->getKeyName(), 'DESC'), $getter]);
            }

            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($model);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'browse', $isModelTranslatable);

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        // Check if a default search key is set
        $defaultSearchKey = $dataType->default_search_key ?? null;

        // Actions
        $actions = [];
        if (!empty($dataTypeContent->first())) {
            foreach (Voyager::actions() as $action) {
                $action = new $action($dataType, $dataTypeContent->first());

                if ($action->shouldActionDisplayOnDataType()) {
                    $actions[] = $action;
                }
            }
        }

        // Define showCheckboxColumn
        $showCheckboxColumn = false;
        if (Auth::user()->can('delete', app($dataType->model_name))) {
            $showCheckboxColumn = true;
        } else {
            foreach ($actions as $action) {
                if (method_exists($action, 'massAction')) {
                    $showCheckboxColumn = true;
                }
            }
        }

        // Define orderColumn
        $orderColumn = [];
        if ($orderBy) {
            $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + ($showCheckboxColumn ? 1 : 0);
            $orderColumn = [[$index, $sortOrder ?? 'desc']];
        }

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'actions',
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortOrder',
            'searchNames',
            'isServerSide',
            'defaultSearchKey',
            'usesSoftDeletes',
            'showSoftDeleted',
            'showCheckboxColumn'
        ));
    }

    protected function findRelationField($dataType, $searchKey) {
        foreach ($dataType->browseRows as $key => $row) {
            if ($row->type === 'relationship' && ($row->field == $searchKey || $row->details->column == $searchKey)) {
                if($row->details->type == 'hasOne') {
                    return ['join' => 'join',
                        'table' => $row->details->table,
                        'asTable' => "{$row->details->table}_relation",
                        'foreign_key' => $row->details->key,
                        'key' => $row->details->column,
                        'label' => $row->details->label];
                } else {
                    return ['join' => 'leftJoin',
                        'table' => $row->details->table,
                        'asTable' => "{$row->details->table}_relation",
                        'foreign_key' => $row->details->column,
                        'key' => $row->details->key,
                        'label' => $row->details->label];
                }
            }
        }
        return $searchKey;
    }
}
