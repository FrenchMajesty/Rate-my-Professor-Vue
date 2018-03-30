<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use App\Http\Proxy\LoginProxy;
use Illuminate\Http\Request;
use Optimus\Bruno\LaravelController;

class LoginController extends Controller
{

    private $loginProxy;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LoginProxy $loginProxy)
    {
        $this->loginProxy = $loginProxy;
    }

    /**
     * Handle the request to log in a user
     * @param  \Illuminate\Http\Request $request Request
     * @return \Illuminate\Http\Response           
     */
    public function login(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string',
        ])->validate();

        return $this->loginProxy->attemptLogin($request->email, $request->password);
    }

    /**
     * Handle the request to refresh the access token
     * @param  \Illuminate\Http\Request $request Request
     * @return \Illuminate\Http\Response           
     */
    public function refresh(Request $request)
    {
        return $this->loginProxy->attemptRefresh();
    }

    /**
     * Handle the request to logout a user
     * @return \Illuminate\Http\Response 
     */
    public function logout()
    {
        $this->loginProxy->logout();
    }
}
