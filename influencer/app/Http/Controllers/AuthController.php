<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Cookie;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $scope = $request->input('scope');

            if (!$request->user()->tokenCan('admin')) {
                return response([
                    'error' => 'Access denied!',
                ], Response::HTTP_FORBIDDEN);
            }

            $token = $user->createToken($scope, [$scope])->accessToken;

            $cookie = \cookie('jwt', $token, 3600);

            return \response([
                'token' => $token,
            ])->withCookie($cookie);
        }

        return response([
            'error' => 'Invalid Credentials!',
        ], Response::HTTP_UNAUTHORIZED);
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
            'role_id' => 1, // Admin
            'is_influencer' => 1
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

    public function user(): UserResource
    {
        $user = Auth::user();

        $resource = new UserResource($user);

        if($user->isInfluencer()) {
            return $resource;
        }

        return (new UserResource($user))->additional([
            'data' => [
                'permissions' => $user->permissions()
            ]
        ]);
    }

    public function updateInfo(UpdateInfoRequest $request): Application|\Illuminate\Http\Response|ResponseFactory
    {
        $user = Auth::user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response(new UserResource($user), 202);
    }

    public function updatePassword(UpdatePasswordRequest $request): Application|Response|ResponseFactory
    {
        $user = Auth::user();

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return response(new UserResource($user), 202);
    }
}
