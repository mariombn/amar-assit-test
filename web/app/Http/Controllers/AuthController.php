<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index ()
    {
        return response()->json([
            'success' => false,
            'message' => 'Você não tem permissão para acessar essa rota'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $request->user();
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response()->json([
            'success' => true,
            'token' => $token
        ], 200);
    }

    public function authTest(Request $request)
    {
        print_r($request->all());
    }
}
