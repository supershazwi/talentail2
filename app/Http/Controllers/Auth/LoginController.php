<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request) {
      Auth::logout();
      return redirect('/login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if(!$user && $request->input('email')) {
            return back()->with('warning', 'User with entered email address not found.')->withInput();
        } elseif(!$user && $request->input('email') == null) {
            return back()->with('warning', 'Please provide a valid email address.')->withInput();
        }

        if (!$user->verified) {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have previously sent you an activation code, please check your email.')->withInput();
        } else {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect('/');
            } else {
                if($request->input('password') == null && $request->input('email') == null) {
                    return back()->with('warning', 'Please provide a valid email address and password.')->withInput();
                } elseif($request->input('password') == null) {
                    return back()->with('warning', 'Please provide a valid password.')->withInput();
                } else {
                    return back()->with('warning', 'The email and password do not match.')->withInput();
                }
            }
            
        }
    }

    public function authenticated(Request $request, $user)
    {
        if (!$user->verified) {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have previously sent you an activation code, please check your email.');
        }

        return redirect()->intended($this->redirectPath());
    }
}
