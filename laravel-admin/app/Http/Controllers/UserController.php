<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    public function index(): string
    {
        $users = User::paginate();

        return response()->json($users);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function store(UserCreateRequest $request): ResponseFactory|Application|Response
    {
        $user = User::create($request->only('first_name', 'last_name', 'email') + [
            'password' => bcrypt($request->input('password')),
        ]);

        return response($user, ResponseAlias::HTTP_ACCEPTED);
    }

    public function update(UserUpdateRequest $request, int $id): Application|Response|ResponseFactory
    {
        $user = User::findOrFail($id);

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response($user, ResponseAlias::HTTP_ACCEPTED);
    }

    public function destroy(int $id): Application|Response|ResponseFactory
    {
        User::destroy($id);

        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }

    public function user()
    {
        return Auth::user();
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response($user, ResponseAlias::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only('password'));

        return response($user, ResponseAlias::HTTP_ACCEPTED);
    }
}
