<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
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
    public function redirectTo()
    {
       
        $user = Auth::user();
        if ($user->hasRole('Admin'))
        {
            return '/admin/dashboard';
        }
        elseif($user->hasRole('Customer')){
            return '/shop';
        }else
        {
          
            return '/shop';
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

    public function logout(Request $request)
    {

        $user = Auth::user();
        if ($user->hasRole('Admin'))
        {
            $redirect =  '/admin';
        } else
        {

            $redirect  = '/shop';
        }
        Auth::logout();
        return redirect($redirect);
    }

}
