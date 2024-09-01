<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    public function index(): string
    {
        return User::all();
    }

    public function show(int $id): ?User
    {
        return User::find($id);
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
}
