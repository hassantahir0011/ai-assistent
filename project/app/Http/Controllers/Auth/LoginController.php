<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Shop;
use Illuminate\Http\Request;
use Session;
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
    public $redirectTo = '/backend/docs/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

        $this->middleware('guest', ['except' => 'logout']);
    }
//
//    public function redirectTo()
//    {
//        return Session::get('backUrl') ? Session::get('backUrl') : $this->redirectTo;
//    }

    public function logoutToPath()
    {

        return 'backend/login';
    }




    public function showLoginForm()
    {
       // Session::put('backUrl', \URL::previous());
        return view('admin.auth.login');
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('backend/login');
    }


}
