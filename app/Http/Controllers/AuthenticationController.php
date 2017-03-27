<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLogin;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{
    private $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    public function login(StoreLogin $request)
    {
        $this->auth->attempt(['email' => $request->username, 'password' => $request->password]);
        
        return $this->check($request);
    }

    public function logout(Request $request)
    {
        $this->auth->logout();

        return abort(Response::HTTP_NO_CONTENT);
    }

    public function check(Request $request)
    {
        $authenticated = $this->auth->check();
        $data = ['authenticated' => $authenticated];

        return response()->json(
            $authenticated
                ? array_merge($data, ['username' => $this->auth->user()->name])
                : $data);
    }
}
