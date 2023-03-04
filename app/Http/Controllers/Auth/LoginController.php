<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        Auth::logout();
        session()->flush();
        $this->middleware('guest');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }


    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    }

    public function attemptLogin(Request $request)
    {
        return Auth::guard('customer')->attempt([
            'email' => $request->email,
            'password' => $request->password,
            'isVerified' => 1
        ], true);

    }
    protected function sendLoginResponse(Request $request)
    {
        if($request->get('redirect')){
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('home');
    }
    public function logout()
    {
        Auth::guard('customer')->logout();
        session()->flush();
        session()->regenerate();

        return redirect()->route('home');
    }
}
