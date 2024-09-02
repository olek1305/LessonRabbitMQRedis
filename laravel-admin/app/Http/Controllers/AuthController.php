<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
        public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // User login attempt
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Creating a token with Passport
            $tokenResult = $user->createToken('admin');
            $token = $tokenResult->accessToken;

            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $tokenResult->token->expires_at,
            ]);
        }

        // Failed login attempt
        return response()->json(['message' => 'Invalid Credentials!'], Response::HTTP_UNAUTHORIZED);
    }
}
