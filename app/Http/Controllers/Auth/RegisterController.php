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
     * Create a new user instance for a student after a valid registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\User
     */
    public function createStudent(Request $request)
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
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account' => 'student',
        ]);
    }

    /**
     * Create a new user instance for a professor after a valid registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\User
     */
    public function createProf(Request $request)
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
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account' => 'professor',
        ]);
    }
}
