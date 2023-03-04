<?php

namespace App\Http\Controllers;

use App\Events\SendMailProcessed;
use App\Functions\Functions;
use App\Models\Address;
use App\Models\Customer;
use App\Models\MailConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;

class CustomerController extends \TCG\Voyager\Http\Controllers\VoyagerBaseController
{

    //***************************************
    //                _____
    //               |  __ \
    //               | |__) |
    //               |  _  /
    //               | | \ \
    //               |_|  \_\
    //
    //  Read an item of our Data Type B(R)EAD
    //
    //****************************************

    public function show(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);
            $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        // Replace relationships' keys for labels and create READ links if a slug is provided.
        $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType, true);

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'read');

        // Check permission
        $this->authorize('read', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.read';

        if (view()->exists("voyager::$slug.read")) {
            $view = "voyager::$slug.read";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    //***************************************
    //                ______
    //               |  ____|
    //               | |__
    //               |  __|
    //               | |____
    //               |______|
    //
    //  Edit an item of our Data Type BR(E)AD
    //
    //****************************************

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? app($dataType->model_name)->findOrFail($id)
            : DB::table($dataType->name)->where('id', $id)->first(); // If Model doest exist, get data from table name

        foreach ($dataType->editRows as $key => $row) {
            $dataType->editRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;

        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

        // Check permission
        $this->authorize('edit', $data);

        $condition = [
            'firstName' => ['required', 'string', 'max:191'],
            'lastName' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'state' => 'required|max:191',
            'city' => 'required|max:191',
            'address' => 'required|max:191',
            'zip' => 'required|max:191',
            'phone' => 'required|regex:/^[01]?[- .]?([2-9]\d{2})?[- .]?\d{3}[- .]?\d{4}$/',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
        ];
        if($request->role_id == 1) {
            $condition['physician_name'] = 'required|string|max:191';
            $condition['physician_license_number'] = 'required|max:191';
            $condition['physician_npi_number'] = 'required|max:191';
        }

        if(!empty($request->password)){
            $condition['password'] = ['required', 'min:8'];
        }
        $validator = Validator::make($request->all(),$condition );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }

        DB::beginTransaction();
        try {
            $dataCustomer = [
                'firstName' => $request['firstName'],
                'lastName' => $request['lastName'],
                'email' => $request['email'],
                'gender' => $request['gender'],
                'role_id' => $request['role_id'],
                'dob' => $request['dob'],
                'token' => Hash::make($request['email']. $request['password']),
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
            ];
            if($request->role_id == 1) {
                if($request->role_id == 1) {
                    $dataCustomer['physician_name'] = $request->physician_name;
                    $dataCustomer['physician_license_number'] = $request->physician_license_number;
                    $dataCustomer['physician_npi_number'] = $request->physician_npi_number;
                    $dataCustomer['draw_patients'] = $request->draw_patients;
                    $dataCustomer['blood_draw'] = $request->blood_draw;
                    $dataCustomer['special_requests'] = $request->special_requests;
                }
            }

            if(!empty($request->password)){
                $dataCustomer['password'] = Hash::make($request['password']);
            }

            $customer = Customer::where('id',$id)->update($dataCustomer);

            $dataAddress = [
                'phone' => $request['phone'],
                'country_id' => $request['country'],
                'state' => $request['state'],
                'city' => $request['city'],
                'address' => $request['address'],
                'zip' => $request['zip']
            ];
            Address::where('customer_id',$id)->update($dataAddress);
            DB::commit();

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => __('voyager::generic.successfully_updated')." {$dataType->display_name_singular}",
                    'alert-type' => 'success',
                ]);
        }catch (\Exception $exception){
            DB::rollback();
            return redirect()->back()->withInput($request->all())->withErrors($exception->getMessage());
        }



    }

    //***************************************
    //
    //                   /\
    //                  /  \
    //                 / /\ \
    //                / ____ \
    //               /_/    \_\
    //
    //
    // Add a new item of our Data Type BRE(A)D
    //
    //****************************************

    public function create(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? new $dataType->model_name()
            : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    /**
     * POST BRE(A)D - Store data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));
        $condition = [
            'firstName' => ['required', 'string', 'max:191'],
            'lastName' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:customers'],
            'password' => ['required', 'min:8'],
            'state' => 'required|max:191',
            'city' => 'required|max:191',
            'address' => 'required|max:191',
            'zip' => 'required|numeric',
            'dob' => 'nullable|before:' . date('Y-m-d'),
            'phone' => 'required',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
        ];
        if($request->role_id == 1) {
            $condition['physician_name'] = 'required|string|max:191';
            $condition['physician_license_number'] = 'required|max:191';
            $condition['physician_npi_number'] = 'required|max:191';
        }

        $validator = Validator::make($request->all(), $condition);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }

        DB::beginTransaction();
        try {
            $dataCustomer = [
                'firstName' => $request['firstName'],
                'lastName' => $request['lastName'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'gender' => $request['gender'],
                'role_id' => $request['role_id'],
                'dob' => $request['dob'],
                'token' => Hash::make($request['email']. $request['password']),
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
            ];

            if($request->role_id == 1) {
                if($request->role_id == 1) {
                    $dataCustomer['physician_name'] = $request->physician_name;
                    $dataCustomer['physician_license_number'] = $request->physician_license_number;
                    $dataCustomer['physician_npi_number'] = $request->physician_npi_number;
                    $dataCustomer['draw_patients'] = $request->draw_patients;
                    $dataCustomer['blood_draw'] = $request->blood_draw;
                    $dataCustomer['special_requests'] = $request->special_requests;
                }
            }

            $customer = Customer::create($dataCustomer);

            $dataAddress = [
                'customer_id' => $customer->id,
                'phone' => $request['phone'],
                'country_id' => $request['country'],
                'state' => $request['state'],
                'city' => $request['city'],
                'address' => $request['address'],
                'zip' => $request['zip']
            ];
            Address::insert($dataAddress);
            $mailConfig = MailConfig::where('code','=','new_customer')->first();
            $body =  Functions::replaceBodyEmail($mailConfig->body,$customer);
            event(new SendMailProcessed($request['email'],$mailConfig->subject,$body));
            DB::commit();
            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => __('voyager::generic.successfully_added_new')." {$dataType->display_name_singular}",
                    'alert-type' => 'success',
                ]);
        }catch (\Exception $exception){
            DB::rollback();
            return redirect()->back()->withInput($request->all())->withErrors($exception->getMessage());
        }

    }

    //***************************************
    //                _____
    //               |  __ \
    //               | |  | |
    //               | |  | |
    //               | |__| |
    //               |_____/
    //
    //         Delete an item BREA(D)
    //
    //****************************************

    public function destroy(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('delete', app($dataType->model_name));

        // Init array of IDs
        $ids = [];
        if (empty($id)) {
            // Bulk delete, get IDs from POST
            $ids = explode(',', $request->ids);
        } else {
            // Single item delete, get ID from URL
            $ids[] = $id;
        }
        foreach ($ids as $id) {
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
            $this->cleanup($dataType, $data);
        }

        $displayName = count($ids) > 1 ? $dataType->display_name_plural : $dataType->display_name_singular;

        $res = $data->destroy($ids);
        $data = $res
            ? [
                'message'    => __('voyager::generic.successfully_deleted')." {$displayName}",
                'alert-type' => 'success',
            ]
            : [
                'message'    => __('voyager::generic.error_deleting')." {$displayName}",
                'alert-type' => 'error',
            ];

        if ($res) {
            event(new BreadDataDeleted($dataType, $data));
        }

        return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
    }

    /**
     * Remove translations, images and files related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $dataType
     * @param \Illuminate\Database\Eloquent\Model $data
     *
     * @return void
     */
    protected function cleanup($dataType, $data)
    {
        // Delete Translations, if present
        if (is_bread_translatable($data)) {
            $data->deleteAttributeTranslations($data->getTranslatableAttributes());
        }

        // Delete Images
        $this->deleteBreadImages($data, $dataType->deleteRows->where('type', 'image'));

        // Delete Files
        foreach ($dataType->deleteRows->where('type', 'file') as $row) {
            if (isset($data->{$row->field})) {
                foreach (json_decode($data->{$row->field}) as $file) {
                    $this->deleteFileIfExists($file->download_link);
                }
            }
        }
    }

    /**
     * Delete all images related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $data
     * @param \Illuminate\Database\Eloquent\Model $rows
     *
     * @return void
     */

    /**
     * Order BREAD items.
     *
     * @param string $table
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        if (!isset($dataType->order_column) || !isset($dataType->order_display_column)) {
            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => __('voyager::bread.ordering_not_set'),
                    'alert-type' => 'error',
                ]);
        }

        $model = app($dataType->model_name);
        $results = $model->orderBy($dataType->order_column, $dataType->order_direction)->get();

        $display_column = $dataType->order_display_column;

        $dataRow = Voyager::model('DataRow')->whereDataTypeId($dataType->id)->whereField($display_column)->first();

        $view = 'voyager::bread.order';

        if (view()->exists("voyager::$slug.order")) {
            $view = "voyager::$slug.order";
        }

        return Voyager::view($view, compact(
            'dataType',
            'display_column',
            'dataRow',
            'results'
        ));
    }

    public function update_order(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        $model = app($dataType->model_name);

        $order = json_decode($request->input('order'));
        $column = $dataType->order_column;
        foreach ($order as $key => $item) {
            $i = $model->findOrFail($item->id);
            $i->$column = ($key + 1);
            $i->save();
        }
    }
}
