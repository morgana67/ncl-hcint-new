<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $searchNames = [
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'country' => 'Country',
            'state' => 'State',
            'city' => 'City',
            'zip' => 'Zip',
            'orderStatus' => 'Order Status'
        ];

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];
        $orders = Order::select('*');
        if ($search->value != '' && $search->key && $search->filter) {
            $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
            $search_value = ($search->filter == 'equals') ? $search->value : '%'.$search->value.'%';
            if($search->key == 'country') {
                $countries = Country::where('name', $search_filter, $search_value)->orWhere('code', $search_filter, $search_value)->toArray();
                $orders->whereIn('country_id', $countries);
            } else {
                $orders->where($search->key, $search_filter, $search_value);
            }
        }
        $orders = $orders->orderBy('id','desc')->paginate(10);

        return view('admin.orders.index',compact('orders', 'search', 'searchNames'));
    }

    public function detail(Request $request,$id){
        $order = Order::where('id',$id)->with('details','customer','country')->firstOrFail();
        return view('admin.orders.detail',compact('order'));
    }

    public function destroy($id){
        $res = Order::where('id',$id)->delete();
        OrderDetail::where('id',$id)->delete();
        $data = $res
            ? [
                'message'    => __('voyager::generic.successfully_deleted')." Order",
                'alert-type' => 'success',
            ]
            : [
                'message'    => __('voyager::generic.error_deleting')." Order",
                'alert-type' => 'error',
            ];
        return redirect()->back()->with($data);
    }


    public function updateOrderStatus(Request $request,$id){
        $res = Order::where('id',$id)->update(['orderStatus' => $request->orderStatus]);
        $data = $res
            ? [
                'message'    => __('voyager::generic.successfully_deleted')." Order",
                'alert-type' => 'success',
            ]
            : [
                'message'    => __('voyager::generic.error_deleting')." Order",
                'alert-type' => 'error',
            ];
        return redirect()->back()->with($data);
    }

    public function updatePaymentStatus(Request $request,$id){
        $res = Order::where('id',$id)->update(['paymentStatus' => $request->paymentStatus]);
        $data = $res
            ? [
                'message'    => "Successfully Update Order Order",
                'alert-type' => 'success',
            ]
            : [
                'message'    => "Failed Update Order",
                'alert-type' => 'error',
            ];
        return redirect()->back()->with($data);
    }

    public function publicPwhResult(Request $request,$id){
        return true;
//        \DB::beginTransaction();
//        try {
//            $order = Order::find($id);
//            $order->public_pwh_result = 1;
//            $order->save();
//
//            $mailConfig = MailConfig::where('code','=','notice_pwh_result')->first();
//            if ($mailConfig){
//                $body =  Functions::replaceBodyEmail($mailConfig->body,$order->customer);
//                $body = str_replace("{{LINK_LOGIN}}", route('login'), $body);
//                event(new SendMailProcessed($order->customer->email,$mailConfig->subject,$body));
//            }
//
//            $data = $order
//                ? [
//                    'message'    => "Send email to notify customers of success",
//                    'alert-type' => 'success',
//                ]
//                : [
//                    'message'    => "Send email to notify customers of failure",
//                    'alert-type' => 'error',
//                ];
//            \DB::commit();
//        }catch (\Exception $exception){
//            \DB::rollBack();
//            $data = [
//                'message'    => "Server error",
//                'alert-type' => 'error',
//            ];
//        }
//        return redirect()->back()->with($data);

    }
}
