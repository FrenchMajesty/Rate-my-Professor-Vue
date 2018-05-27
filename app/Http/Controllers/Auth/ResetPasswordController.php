<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Optimus\Bruno\LaravelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        $password = $request->input('current_password');

        if(!Hash::check($password, $request->user()->password)) {
            $errors = ['current_password' => ['The current password is incorrect.']];
            return response()->json(compact('errors'), 422);
        }

        $user = Auth::user();
        $user->password = bcrypt($request->input('new_password'));
        $user->save();
    }
}
