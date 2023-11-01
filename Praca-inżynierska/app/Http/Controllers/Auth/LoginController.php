<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
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

    //protected $redirectTo = RouteServiceProvider::HOME;

    protected $redirectTo;

    public function redirectTo() {

        if(Auth::user()->roles()->where('role_name','user')->exists()) {
            $this->redirectTo = route('userPage');
            return $this->redirectTo;
        } else if(Auth::user()->roles()->where('role_name','admin')->exists()){
            $this->redirectTo = route('adminPage');
            return $this->redirectTo;
        } else if(Auth::user()->roles()->where('role_name','mod')->exists()){
            $this->redirectTo = route('modPage');
            return $this->redirectTo;
        } else {
            $this->redirectTo = '/homePage';
            return $this->redirectTo;
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
