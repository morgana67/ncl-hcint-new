<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Hash;
use DB;
class ProfileController extends Controller
{
    public function profile(Request $request){
        $user = Customer::where('id',user()->getAuthIdentifier())->with(['address' => function ($query){
            return $query->where('addressType','=','billing');
        }])->first();
        if($request->isMethod('POST')){
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
            if($user->role_id == 1) {
                $condition['physician_name'] = 'required|string|max:191';
                $condition['physician_license_number'] = 'required|max:191';
                $condition['physician_npi_number'] = 'required|max:191';
                $validation['fax'] = 'required|regex:/^[01]?[- .]?([2-9]\d{2})?[- .]?\d{3}[- .]?\d{4}$/';
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
                    'token' => \Illuminate\Support\Facades\Hash::make($request['email']. $request['password']),
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'instagram' => $request->instagram,
                ];
                if(isset($request->is_doctor_register)) {
                    $dataCustomer['physician_name'] = $request->physician_name;
                    $dataCustomer['physician_license_number'] = $request->physician_license_number;
                    $dataCustomer['physician_npi_number'] = $request->physician_npi_number;
                    $dataCustomer['draw_patients'] = $request->draw_patients;
                    $dataCustomer['blood_draw'] = $request->blood_draw;
                    $dataCustomer['special_requests'] = $request->special_requests;
                } else {
                    $dataCustomer['gender'] = $request['gender'];
                }

                $customerId = Customer::where('id',user()->getAuthIdentifier())->update($dataCustomer);

                $dataAddress = [
                    'phone' => $request['phone'],
                    'fax' => $request['fax'],
                    'country_id' => $request['country'],
                    'state' => $request['state'],
                    'city' => $request['city'],
                    'address' => $request['address'],
                    'zip' => $request['zip']
                ];
                Address::where('customer_id',$user->id)->update($dataAddress);
                DB::commit();
                message_set('Profile updated successfully','success');
                return redirect()->back();
            }catch (\Exception $exception){
                DB::rollback();
                return redirect()->back()->withInput($request->all())->withErrors($exception->getMessage());
            }
        }
        return view('profile.index',compact('user'));
    }
    public function changePassword(Request $request){
        if($request->isMethod('POST')){
            if (!Hash::check($request->old_password, user()->getAuthPassword())){
                message_set('Old passwords do not match','danger');
                return redirect()->back();
            }else{
                $validator = Validator::make($request->all(),[
                    'old_password' => 'required',
                    'password' => 'required|min:8|confirmed',
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator->getMessageBag());
                }

                Customer::where('id',\user()->getAuthIdentifier())->update(['password' => bcrypt($request->password)]);
                message_set('Password changed successfully','success');
                return redirect()->back();
            }
        }
        return view('profile.change-password');
    }

    public function myOrder(){
        $orders = Order::where(function ($query){
            if(!empty(\request()->get('order_id'))){
                $query->where('id','LIKE','%' .\request()->get('order_id'). '%');
            }
            if(!empty(\request()->get('name'))){
                $query->where(function ($query){
                    $query->where('lastName','LIKE','%' .\request()->get('name'). '%');
                    $query->orWhere('firstName','LIKE','%' .\request()->get('name'). '%');
                });
            }
            if(!empty(\request()->get('nick_name'))){
                $query->where('nick_name','LIKE','%' .\request()->get('nick_name'). '%');
            }
        })->where('customer_id',user()->getAuthIdentifier())->orderBy('id','desc')->with('details','customer','country')->paginate(20);
        return view('profile.my-order',compact('orders'));
    }

    public function orderDetail(Request $request,$id){
        $order = Order::where('id',$id)->where(function ($query){
            return $query->where('customer_id','=',user()->getAuthIdentifier())
                         ->orWhere('email','=',user()->email);
        })->with('details','customer','country')->first();
        if(empty($order)) return abort(404,'You do not have permission to view this Order');
        return view('profile.order-detail',compact('order'));
    }

    public function downloadRequisitionOrder(Request $request,$id){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,env('PWN_END_POINT_ORDER')."/{$id}/pdfs/requisition");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $token = generateToken();
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            "Authorization:Bearer {$token}"
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec ($ch);
        curl_close ($ch);

        header('Cache-Control: public');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="RequisitionOrder'.$id.'.pdf"');
        header('Content-Length: '.strlen($server_output));
        echo $server_output;
        exit();
    }

    public function downloadResultTest(Request $request,$id){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,env('PWN_END_POINT_ORDER')."/{$id}/pdfs/results");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $token = generateToken();
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            "Authorization:Bearer {$token}"
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec ($ch);
        curl_close ($ch);

        header('Cache-Control: public');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="Order Result'.$id.'.pdf"');
        header('Content-Length: '.strlen($server_output));
        echo $server_output;
        exit();
    }

    public function curl($field = array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api-staging.pwnhealth.com/v2/labs/orders");
        if ($field && !empty($field)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $field);
        } //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $token = generateToken();
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            "Authorization:Bearer {$token}"
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        return json_decode($server_output);
    }

}
