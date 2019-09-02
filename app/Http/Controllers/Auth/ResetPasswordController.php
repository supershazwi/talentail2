<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(Request $request) 
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if(!$user && $email) {
            return back()->with('warning', 'User with entered email address not found.')->withInput();
        }

        if(!$user && $email == null) {
            return back()->with('warning', 'Please provide a valid email address.')->withInput();
        }

        if($password == null) {
            return back()->with('warning', 'Please provide a new password.')->withInput(); 
        }

        $user->password = bcrypt($request->input('password'));

        $user->save();

        return redirect('login')->with('passwordResetSuccess', true);
    }
}
