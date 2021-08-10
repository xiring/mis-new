<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|exists:users,' . $this->username() . ',is_active,1',
            'password' => 'required',
        ], [
            $this->username() . '.exists' => 'The account has been disabled due to pending payments.Please contact software provider.'
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if(Auth::check()) {
            if ($user->user_type == 1) {
                return redirect()->route('master.dashboard');
            }elseif ($user->user_type == 2) {
                return redirect()->route('school.dashboard');
            }elseif ($user->user_type == 6) {
                return redirect()->route('accountant.dashboard');
            }
        }else{
            return redirect('/login');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
