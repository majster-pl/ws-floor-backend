<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

    // protected function login()
    // {
    //     if (Auth::check()) {
    //         return new Response("Allready logged in!", 200);
    //     }
    // }

    protected function authenticated(Request $request, $user)
    {
        // return new Response(["User not authenticated"], 401);
        $user = Auth::user();
        $id = Auth::id();
        if (isset($id)) {
            return new Response($user, 200);
        } else {
            return new Response(["User not authenticated"], 401);
        }

    }

    // function to hangle logout request
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $this->guard()->logout();
            $request->session()->invalidate();
            return new Response(["You have been successfully logged out"], 200);
        } else {
            return new Response(["User not authenticated"], 401);
        }
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;


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
