<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\User;
use Illuminate\Support\Facades\DB;

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
    protected $redirectTo = 'master/bank';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function username(){
        return 'username';
    }

    /**
     *
     */
    protected function authenticated()
    {
        $hotel = DB::table('hotel_profile')->first();

        $data = [
            'name'  => $hotel->name,
            'logo'  => $hotel->logo,
            'address'  => $hotel->address,
            'phone'  => $hotel->phone,
            'fax'  => $hotel->fax,
            'email'  => $hotel->email
        ];

        session($data);
    }

}
