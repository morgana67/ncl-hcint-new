<?php

namespace App\Http\Controllers\Voyager\Core;

use TCG\Voyager\Http\Controllers\VoyagerUserController as BaseVoyagerUserController;

class VoyagerUserController extends BaseVoyagerUserController
{
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
