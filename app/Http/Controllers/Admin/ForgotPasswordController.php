<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendMailProcessed;
use App\Functions\Functions;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MailConfig;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('vendor.voyager.forgot-password');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function reset_password(Request $request)
    {
        try {
            $this->validateEmail($request);
            $user = User::where("email", "=", $request->email)->first();
            if (!empty($user)) {
                $password = substr(md5(microtime()), rand(0, 26), 8);
                $user->password = bcrypt($password);
                $user->save();

                $replaces['NAME'] = $user->firstName . ' ' . $user->lastName;
                $replaces['PASSWORD'] = $password;
                $mailConfig = MailConfig::where('code','=','forgot_password')->first();
                $body =  Functions::replaceBodyEmail($mailConfig->body,$user);
                $body = str_replace("{{PASSWORD}}", $password, $body);
                event(new SendMailProcessed($request->email,$mailConfig->subject,$body));
                \Session::flash('success', 'A new password reset has been resent to '. $request->email);
                return redirect()->route('voyager.login');
            } else {
                return redirect()->back()->withErrors('That email does not exist.');
            }
            return redirect()->route('login');
        }catch (\Exception $exception){
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
}
