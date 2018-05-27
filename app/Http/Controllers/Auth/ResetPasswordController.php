<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Optimus\Bruno\LaravelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends LaravelController
{
    /**
     * Handle an user's request to update their password
     * @param  \Illuminate\Http\Request $request Request
     * @return void           
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ])->validate();

        $credentials = [
            'email' => $request->user()->email,
            'password' => $request->input('current_password'),
        ];

        if(!Auth::attempt($credentials)) {
            $errors = ['current_password' => ['The current password is incorrect.']];
            return abort(422, compact('errors'));
        }

        $user = Auth::user();
        $user->password = bcrypt($request->input('new_password'));
        $user->save();
    }
}
