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
        $success = $this->auth->attempt(['email' => $request->username, 'password' => $request->password]);

        return response()->json(['success' => $success]);
    }

    public function logout(Request $request)
    {
        $this->auth->logout();

        return abort(Response::HTTP_NO_CONTENT);
    }
}
