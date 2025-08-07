<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(LoginRequest $request) : JsonResponse {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(
                ['message' => 'Invalid Login'],
                401
            );
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        dd($token);
        $response = new LoginResource([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
        return response()->json($response);
    }
}
