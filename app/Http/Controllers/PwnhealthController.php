<?php

namespace App\Http\Controllers;

use App\Events\SendMailProcessed;
use App\Models\Order;
use Illuminate\Http\Request;
use Log;

class PwnhealthController extends Controller
{
//    Route::match(['GET','POST'],'/order_approved','PwnhealthController@order_approved')->name('order_approved');
//    Route::match(['GET','POST'],'/order_rejected','PwnhealthController@order_rejected')->name('order_rejected');
//    Route::match(['GET','POST'],'/order_canceled','PwnhealthController@order_canceled')->name('order_canceled');
//    Route::match(['GET','POST'],'/order_deferred','PwnhealthController@order_deferred')->name('order_deferred');
//    Route::match(['GET','POST'],'/results_released','PwnhealthController@results_released')->name('results_released');
//    Route::match(['GET','POST'],'/results_on_hold','PwnhealthController@results_on_hold')->name('results_on_hold')

    public function order_approved(Request $request){
        try {
            if(!empty($request->id)){
                $status = 'approved';
                $isDr = false;
                $order = Order::where(['pwh_order_id' => $request->id])->firstOrFail();
                $url = route('login',['redirect' => route('orderDetail',['id' => $order->id])]);
                $name = $order->firstName. ' '.$order->lastName;
                $order->update(['pwh_status' => 'Order Approved']);
                $bodyRender = view('emails.pwh_mail',compact('name','status','isDr','order','url'))->render();
                event(new SendMailProcessed($order->email,'Your Order was Approved',$bodyRender));
                if($order->email != $order->customer->email && $order->customer->role_id == 1){
                    $isDr = true;
                    $name = $order->customer->firstName. ' '.$order->customer->lastName;
                    $url = route('login',['redirect' => route('myOrder')]);
                    $bodyRender = view('emails.pwh_mail',compact('name','status','isDr','order','url'))->render();
                    event(new SendMailProcessed($order->customer->email,'Order of the patient was Approved',$bodyRender));
                }
                Log::debug('--- order_approved success---'.json_encode($request->all()));
                return true;
            }
        }catch (\Exception $exception){
            Log::debug('--- order_approved fail ---'.json_encode($request->all()).'---'.$exception->getMessage());
        }

    }

    public function order_rejected(Request $request){
        try {
            if(!empty($request->id)){
                $status = 'rejected';
                $isDr = false;
                $order = Order::where(['pwh_order_id' => $request->id])->firstOrFail();
                $url = route('login',['redirect' => route('orderDetail',['id' => $order->id])]);
                $name = $order->firstName. ' '.$order->lastName;
                $order->update(['pwh_status' => 'Order Rejected']);
                $bodyRender = view('emails.pwh_mail',compact('name','status','isDr','order','url'))->render();
                event(new SendMailProcessed($order->email,'Your Order was Rejected',$bodyRender));
                if($order->email != $order->customer->email && $order->customer->role_id == 1){
                    $isDr = true;
                    $url = route('login',['redirect' => route('myOrder')]);
                    $name = $order->customer->firstName. ' '.$order->customer->lastName;
                    $bodyRender = view('emails.pwh_mail',compact('name','status','isDr','order','url'))->render();
                    event(new SendMailProcessed($order->customer->email,'Order of the patient was Rejected',$bodyRender));
                }
                Log::debug('--- order_rejected rejected---'.json_encode($request->all()));
                return true;
            }
        }catch (\Exception $exception){
            Log::debug('--- order_rejected fail ---'.json_encode($request->all()).'---'.$exception->getMessage());
        }
    }

    public function order_canceled(Request $request){
        try {
            if(!empty($request->id)){
                $status = 'canceled';
                $isDr = false;
                $order = Order::where(['pwh_order_id' => $request->id])->firstOrFail();
                $name = $order->firstName. ' '.$order->lastName;
                $order->update(['pwh_status' => 'Order Canceled']);
                $url = route('login',['redirect' => route('orderDetail',['id' => $order->id])]);
                $bodyRender = view('emails.pwh_mail',compact('name','status','isDr','order','url'))->render();
                event(new SendMailProcessed($order->email,'Your Order was Canceled',$bodyRender));

                if($order->email != $order->customer->email && $order->customer->role_id == 1){
                    $isDr = true;
                    $url = route('login',['redirect' => route('myOrder')]);
                    $name = $order->customer->firstName. ' '.$order->customer->lastName;
                    $bodyRender = view('emails.pwh_mail',compact('name','status','isDr','order','url'))->render();
                    event(new SendMailProcessed($order->customer->email,'Order of the patient was Canceled',$bodyRender));
                }

                Log::debug('--- order_canceled success---'.json_encode($request->all()));
                return true;
            }
        }catch (\Exception $exception){
            Log::debug('--- order_canceled fail ---'.json_encode($request->all()).'---'.$exception->getMessage());
        }
    }


//    Route::match(['GET','POST'],'/order_approved','PwnhealthController@order_approved')->name('order_approved');
//    Route::match(['GET','POST'],'/order_rejected','PwnhealthController@order_rejected')->name('order_rejected');
//    Route::match(['GET','POST'],'/order_canceled','PwnhealthController@order_canceled')->name('order_canceled');
//    Route::match(['GET','POST'],'/order_deferred','PwnhealthController@order_deferred')->name('order_deferred');
//    Route::match(['GET','POST'],'/results_released','PwnhealthController@results_released')->name('results_released');
//    Route::match(['GET','POST'],'/results_on_hold','PwnhealthController@results_on_hold')->name('results_on_hold')

    public function result_released(Request $request)
    {
        try {
            if(!empty($request->id)){
                $order = Order::where(['pwh_order_id' => $request->id])->firstOrFail();
                $status = 'available';
                $isDr = false;
                $name = $order->firstName. ' '.$order->lastName;
                $order->update(['pwh_status' => 'Result released: '.$request->result, 'orderStatus' => 'completed']);
                $url = route('login',['redirect' => route('orderDetail',['id' => $order->id])]);
                $bodyRender = view('emails.pwh_mail_result',compact('name','isDr','order','status','url'))->render();
                event(new SendMailProcessed($order->email,'Your Order Results are now Available',$bodyRender));

                if($order->email != $order->customer->email && $order->customer->role_id == 1){
                    $isDr = true;
                    $url = route('login',['redirect' => route('myOrder')]);
                    $name = $order->customer->firstName. ' '.$order->customer->lastName;
                    $bodyRender = view('emails.pwh_mail_result',compact('name','isDr','order','status','url'))->render();
                    event(new SendMailProcessed($order->customer->email,'Order of the patient are now Available',$bodyRender));
                }

                Log::debug('--- result_released success---'.json_encode($request->all()));
                return true;
            }
        }catch (\Exception $exception){
            Log::debug('--- result_released fail ---'.json_encode($request->all()).'---'.$exception->getMessage());
        }
    }

    public function result_on_hold(Request $request)
    {
        try {
            if(!empty($request->id)){
                $status = 'on hold';
                $isDr = false;
                $order = Order::where(['pwh_order_id' => $request->id])->firstOrFail();
                $name = $order->firstName. ' '.$order->lastName;
                $order->update(['pwh_status' => 'Result on Hold: '.$request->result]);
                $url = route('login',['redirect' => route('orderDetail',['id' => $order->id])]);
                $bodyRender = view('emails.pwh_mail_result',compact('name','isDr','order','status','url'))->render();
                event(new SendMailProcessed($order->email,'Your Order Results are now On Hold',$bodyRender));

                if($order->email != $order->customer->email && $order->customer->role_id == 1){
                    $isDr = true;
                    $url = route('login',['redirect' => route('myOrder')]);
                    $name = $order->customer->firstName. ' '.$order->customer->lastName;
                    $bodyRender = view('emails.pwh_mail_result',compact('name','isDr','order','status','url'))->render();
                    event(new SendMailProcessed($order->customer->email,'Order of the patient now On Hold',$bodyRender));
                }

                Log::debug('--- result_on_hold success---'.json_encode($request->all()));
                return true;
            }
        }catch (\Exception $exception){
            Log::debug('--- result_on_hold fail ---'.json_encode($request->all()).'---'.$exception->getMessage());
        }
    }
}
