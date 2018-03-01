<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
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
}
