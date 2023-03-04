<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendMailProcessed;
use App\Functions\Functions;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MailConfig;
use App\Models\PasswordReset;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Address;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     *
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => ['required', 'string', 'max:191'],
            'lastName' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:customers'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/'],
            'state' => 'required|max:191',
            'city' => 'required|max:191',
            'address' => 'required|max:191',
            'zip' => 'required|max:191',
            'phone' => 'required|regex:/^[01]?[- .]?([2-9]\d{2})?[- .]?\d{3}[- .]?\d{4}$/',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function postRegister(Request $request)
    {
        $role = 2;
        $validation = [
            'firstName' => ['required', 'string', 'max:191'],
            'lastName' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:customers'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/'],
            'state' => 'required|max:191',
            'city' => 'required|max:191',
            'address' => 'required|max:191',
            'zip' => 'required|max:191',
            'phone' => 'required|regex:/^[01]?[- .]?([2-9]\d{2})?[- .]?\d{3}[- .]?\d{4}$/',
        ];
        if(isset($request->is_doctor_register)) {
            $validation['physician_name'] = 'required|string|max:191';
            $validation['physician_license_number'] = 'required|max:191';
            $validation['physician_npi_number'] = 'required|max:191';
            $validation['fax'] = 'required|regex:/^[01]?[- .]?([2-9]\d{2})?[- .]?\d{3}[- .]?\d{4}$/';
            $role = 1;
        }

        $validator = Validator::make($request->all(), $validation);

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
                'role_id' => $role,
                'isVerified' => 0,
                'token' => Hash::make($request['email']. $request['password']),
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
            $customerId = Customer::insertGetId($dataCustomer);

            $dataAddress = [
                'customer_id' => $customerId,
                'phone' => $request['phone'],
                'country_id' => $request['country'],
                'state' => $request['state'],
                'city' => $request['city'],
                'address' => $request['address'],
                'zip' => $request['zip'],
                'fax' => $request['fax']
            ];
            Address::insert($dataAddress);

            $token = substr(md5(mt_rand()), 0, 32);
            PasswordReset::insert([
                'email' => $request['email'],
                'token' => $token,
                'created_at' => now(),
            ]);

            $replaces['NAME'] =  $request['firstName'] . ' ' .  $request['lastName'];
            $mailConfig = MailConfig::where('code','=','registration')->first();
            if ($mailConfig){
                $customer = Customer::find($customerId);
                $body =  Functions::replaceBodyEmail($mailConfig->body,$customer);
                $paramGet = [
                    'token' => $token
                ];
                $body = str_replace("{{LINK_VERIFY}}", route('verifyAccount').'?'.http_build_query($paramGet), $body);
                event(new SendMailProcessed($request->email,$mailConfig->subject,$body));
            }
            if(isset($request->is_doctor_register)) {
                $mailConfig = MailConfig::where('code','=','new_doctor')->first();
                if ($mailConfig){
                    $customer = Customer::find($customerId);
                    $body =  Functions::replaceBodyEmail($mailConfig->body,$customer);
                    $body = str_replace("{{FIRST_NAME}}", $request['firstName'], $body);
                    $body = str_replace("{{LAST_NAME}}", $request['lastName'], $body);
                    $body = str_replace("{{EMAIL}}", $request['email'], $body);
                    $body = str_replace("{{PHYSICIAN_NAME}}", $request->physician_name, $body);
                    $body = str_replace("{{PHYSICIAN_LICENSE_NUMBER}}", $request->physician_license_number, $body);
                    $body = str_replace("{{PHYSICIAN_NPI_NUMBER}}", $request->physician_npi_number, $body);
                    $body = str_replace("{{DRAW_PATIENTS_OFFICE}}", $request->draw_patient ? "YES" : "NO", $body);
                    $body = str_replace("{{BLOOD_DRAW_SUPPLIES}}", $request->blood_draw  ? "YES" : "NO", $body);
                    $body = str_replace("{{ANY_SPECIAL_REQUEST}}", $request->special_requests, $body);
                    $body = str_replace("{{LINK_CUSTOMER}}", route('voyager.customers.show', $customer->id), $body);
                    event(new SendMailProcessed(setting('site.email_receive_notification'),$mailConfig->subject,$body));
                }
            }
            DB::commit();

            return redirect()->route('login')->with('success', 'We have sent you a verification email. Please check your mail !');
        }catch (\Exception $exception){
            DB::rollback();
            return redirect()->back()->withInput($request->all())->withErrors($exception->getMessage());
        }
    }

    public function verifyAccount(Request $request){
        $passwordPassword = PasswordReset::where('token','=',$request->token)->first();
        if (!$passwordPassword) return abort(404);
        $customer = Customer::where('email','=',$passwordPassword->email)->first();
        if($customer) {
            $customer->isVerified = 1;
            $customer->save();
            PasswordReset::where('email','=',$request->email)->delete();
            return redirect()->route('login')->with('success', 'Account verification is successful');
        }
        return abort(404);
    }

    public function doctorRegister() {
        return view('auth.register', ['is_doctor_register' => true]);
    }
}
