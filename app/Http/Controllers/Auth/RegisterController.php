<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\User
     */
    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'firstname' => 'required|alpha_dash|max:255',
            'lastname' => 'required|alpha_dash|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'terms' => 'required|accepted',
            //'school' => 'required|exists:schools,id',
        ])->validate();
           
        return User::create([
            'name' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}
