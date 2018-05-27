<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    /**
     * Handle the request to authenticate an user
     * @param  \Illuminate\Http\Request $request Request
     * @return array          
     */
    public function login(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|string|email',
    		'password' => 'required|string',
    	]);

    	$client = new \GuzzleHttp\Client();
    	$response = $client->request('POST', env('APP_URL').'/oauth/token', [
    		'client_id' => env('API_CLIENT_ID'),
    		'client_secret' => env('API_CLIENT_SECRET'),
    		'grant_type' => 'password',
    		'username' => $request->email,
    		'password' => $request->password,
    	]);

    	return $response->getBody();
    }

    /**
     * Handle a request to update a user's account information after validation
     * @param  \Illuminate\Http\Request $request Request
     * @param \App\User $user The user instance injected
     * @return mixed         
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'firstname' => 'required|alpha_dash|max:255',
            'lastname' => 'required|alpha_dash|max:255',
            'email' => 'required|email',
        ]);

        $isEmailTaken = User::where('email', $request->email)
            ->whereNotIn('id', [$user->id])
            ->first();

        if($isEmailTaken) {
            $errors = ['email' => ['This email is already used.']];
            return response()->json(compact('errors'), 422);
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->save();
        
        return $user;
    }
}
