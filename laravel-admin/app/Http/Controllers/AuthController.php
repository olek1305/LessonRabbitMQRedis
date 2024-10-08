<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Cookie;
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

            $cookie = cookie('jwt', $token, 60 * 24);

            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $tokenResult->token->expires_at,
            ])->withCookie($cookie);
        }

        // Failed login attempt
        return response()->json(['message' => 'Invalid Credentials!'], Response::HTTP_UNAUTHORIZED);
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->token()->revoke();

        $cookie = cookie::forget('jwt');

        return \response()->json([
            'message' => 'Logged out successfully!'
        ])->withCookie($cookie);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        // Creating a new user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 3 //Viewer
        ]);

        // Generating a token using Passport
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        // Returning a response with a token
        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->token->expires_at->toDateTimeString(),
        ], Response::HTTP_CREATED);
    }

}
