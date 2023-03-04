<?php

namespace App\Http\Controllers;

use App\Events\SendMailProcessed;
use App\Functions\Functions;
use App\Models\Address;
use App\Models\Customer;
use App\Models\MailConfig;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_SK'));
    }

    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function view(){
        $user = Customer::where('id',user()->id)->first();
        if ($user == null) return redirect()->route('login');

        $addressTable = Address::where('customer_id',user()->id)->get();

        $mandatoryProducts = Product::active()->additionalType()->where('mandatory',1)->orderBy('name','ASC')->get();

        $address['billing'] = array();
        $address['patient'] = array();


        $productsAvailable = Product::where('type','NOT LIKE','%additional%')->where('status',1)->where('mandatory',0)->orderBy('name','ASC')->get();
        foreach($addressTable as $e){
            if ($e->addressType == 'billing'){
                $address['billing'] = $e;
            }else{
                $address['patient'] = $e;
            }
        }

        return view('front.cart.checkout',compact('user','address','mandatoryProducts','productsAvailable'));
    }

    public function checkoutProceed(Request $request){
        $validator = \Validator::make($request->all(),[
            'firstName' => ['required', 'string', 'max:191'],
            'lastName' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'date' => 'required',
            'month' => 'required',
            'year' => 'required',
            'address' => 'required|string|max:191',
            'country_id' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required|numeric',
            'phone' => 'required|regex:/^[01]?[- .]?([2-9]\d{2})?[- .]?\d{3}[- .]?\d{4}$/',
            'cc' => 'required|max:16',
            'cvc' => 'required|max:4',
            'expMonth' => 'required',
            'expYear' => 'required'
        ]);
        if ($validator->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        };
        DB::beginTransaction();
        try {
            $token = \Stripe\Token::create([
                'card' => [
                    'number' => $request->cc,
                    'exp_month' => $request->expMonth,
                    'exp_year' => $request->expYear,
                    'cvc' => $request->cvc,
                ],
            ]);
            $y = $request->year;
            $m = $request->month;
            $d = $request->date;
            $dob = "{$y}-{$m}-{$d}";

            if (isset(user()->stripe_customer_id)) {
                $stripeCustomerId = user()->stripe_customer_id;
                $customer = \Stripe\Customer::update($stripeCustomerId, array('source' => $token['id']));
            }else{
                $customer = \Stripe\Customer::create([
                    'source' => $token['id'],
                    'email' => $request->email,
                    'metadata' => [
                        "First Name" => $request->firstName,
                        "Last Name" => $request->lastName
                ]]);
                Customer::where('id',user()->id)->update(['stripe_customer_id' => $customer['id']]);
                $stripeCustomerId = $customer['id'];
            }
            $defaultSource = $customer['default_source'];

            $mandatoryProducts = Product::select('id','price','sale_price')->active()->additionalType()->where('mandatory',1)->get();

            $order = new Order();
            $order->customer_id = user()->id;
            $order->firstName = $request->firstName;
            $order->lastName = $request->lastName;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->address2 = $request->address2;
            $order->city = $request->city;
            $order->country_id = $request->country_id;
            $order->state = $request->state;
            $order->phone = $request->phone;
            $order->message = $request->message;
            $order->zip = $request->zip;
            $order->totalAmount = $request->totalAmount;
            $order->nick_name = $request->nick_name;
            $order->gender = $request->gender;
            $order->dob = $dob;
            $order->save();


            $ids = array();
            $orderDetail = array();
            foreach (Cart::content() as $product){
                $orderDetail[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $product->qty,
                ];
                if($product->options->type == 'bundle') {
                    $productBundle = Product::find($product->id);
                    foreach($productBundle->productBundle as $productB) {
                        $ids[] = $productB->product_id;
                    }
                } else {
                    $ids[] = $product->id;
                }
            }

            foreach ($mandatoryProducts as $mandatoryProduct){
                $price = !empty($mandatoryProduct->sale_price) ? floatval($mandatoryProduct->sale_price) : floatval($mandatoryProduct->price);
                $orderDetail[] = [
                    'order_id' => $order->id,
                    'product_id' => $mandatoryProduct->id,
                    'price' => $price,
                    'quantity' => 1,
                ];
            }


            OrderDetail::insert($orderDetail);

            if(count($ids) > 0) {
                $tests = Product::select('code')->whereIn('id', $ids)->get()->toArray();
                $dataPwn = (object)[
                    'order' => [
                        'tests' => \Arr::pluck($tests,'code'),
                        'account_number' => "97513297",
                        'customer' => [
                            'first_name' => $request->firstName,
                            'last_name' => $request->lastName,
                            'gender' => ($request->gender == 'm' ? 'Male' : 'Female'),
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'birth_date' => $dob,
                            'address' => [
                                'line' => $request->address,
                                'line2' => $request->address2,
                                'city' => $request->city,
                                'state' => $request->state,
                                'zip' => $request->zip,
                            ]

                        ]
                    ]
                ];
                $response = $this->curl(json_encode($dataPwn));
                if(!empty($response->errors)){
                    DB::rollBack();
                    $msg = "";
                    foreach($response->errors as $error){
                        $msg .= "{$error->field} {$error->messages[0]} <br>";
                    }
                    message_set($msg,'danger');
                    return redirect()->back()->withInput($request->all());
                }else{
                    $amount = $request->cc == '4312317003507772' ? 100 : $request->totalAmount * 100;
                    $charge = \Stripe\Charge::create([
                        'amount' => $amount,
                        'currency' => 'usd',
                        'customer' => $stripeCustomerId,
                        'source' => $defaultSource,
                        'metadata' => [
                            "Order ID" => $order->id,
//                    "Link" => url('admin/order/' . $order_id)
                        ],
                        'capture' => true]);

                    $order->paymentStatus = $charge->status;
                    $order->transaction_id = $charge->id;
                    $order->pwh_order_id = $response->order->id ?? null;
                    $order->pwh_order_link = $response->order->links->ui_customer ?? null;
                    $order->save();
                }
            }
            DB::commit();
            Cart::destroy();
            return redirect()->route('order-success',['id' => $order->id,'sendmail' => 1]);
        }catch(\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput($request->all())->withErrors($exception->getMessage());
        }
    }

    public function curl($field = array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,env('PWN_END_POINT_ORDER'));
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

    public function orderSuccess($id) {
        $order = Order::where('id',$id)->where('customer_id',user()->getAuthIdentifier())->with('details','customer','country')->firstOrFail();
        if(!empty(request()->get("sendmail"))){
            $message = 'You have received an order from ' . $order->firstName.' '.$order->lastName . '. Their order is as follows:';
            $sendAdmin = true;
            $bodyRender = view('emails.mail-order',compact('order','message','sendAdmin'))->render();
            event(new SendMailProcessed(setting('site.email_receive_notification'),'New Order #'.$order->id,$bodyRender));

            $mailConfig = MailConfig::where('code','order_confirmation')->first();
            $message = '';
            $sendAdmin = false;
            $bodyRender = view('emails.mail-order',compact('order','message','sendAdmin'))->render();
            $body =  Functions::replaceBodyEmail($mailConfig->body,user());
            $body = str_replace("{{ORDER_ID}}", $order->id , $body);
            $body = str_replace("{{ORDERINFO}}", $bodyRender , $body);
            event(new SendMailProcessed($order->email,str_replace("{{ORDER_ID}}", $order->id , $mailConfig->subject),$body));
            if($order->email != user()->email){
                event(new SendMailProcessed(user()->email,str_replace("{{ORDER_ID}}", $order->id , $mailConfig->subject),$body));
            }
        }
        return view('front.cart.checkout-success',compact('order'));
    }



    public function findOldInfoByNickname(Request $request): \Illuminate\Http\JsonResponse
    {
        $order = Order::where('nick_name',$request->nick_name)->where('customer_id',user()->getAuthIdentifier())->latest()->first();
        if($order){
            return response()->json(['status' => 'success','data' => $order],200);
        }else{
            return response()->json(['status' => 'fail'],200);
        }
    }


    public function drAddTests(Request $request){
        $products = Product::whereIn('id',$request->ids)->get();
        $arrayCart = array();
        Cart::destroy();
        foreach ($products as $product){
            $arrayCart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => !empty($product->sale_price) ? $product->sale_price : $product->price,
                'qty' => 1,
                'weight' => 0
            ];
        }
        Cart::add($arrayCart);
        return response()->json([
            'cart' => Cart::content(),
            'cart_total' => Cart::total(),
        ],200);
    }

}
