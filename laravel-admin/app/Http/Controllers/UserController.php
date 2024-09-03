<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    public function show(int $id): UserResource
    {
        $user = User::find($id);

        return new UserResource($user);
    }

    public function store(UserCreateRequest $request): ResponseFactory|Application|Response
    {
        $user = User::create($request->only('first_name', 'last_name', 'email', 'role_id') + [
            'password' => bcrypt($request->input('password')),
        ]);

        return response($user, ResponseAlias::HTTP_ACCEPTED);
    }

    public function update(UserUpdateRequest $request, int $id): Application|Response|ResponseFactory
    {
        $user = User::findOrFail($id);

        $user->update($request->only('first_name', 'last_name', 'email', 'role_id'));

        return response(new UserResource($user), 202);
    }

    public function destroy(int $id): Application|Response|ResponseFactory
    {
        User::destroy($id);

        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }

    public function user(): UserResource
    {
        return new UserResource(Auth::user());
    }

    public function updateInfo(UpdateInfoRequest $request): Application|Response|ResponseFactory
    {
        $user = Auth::user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response(new UserResource($user), ResponseAlias::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request): Application|Response|ResponseFactory
    {
        $user = Auth::user();

        $user->update($request->only('password'));

        return response(new UserResource($user), ResponseAlias::HTTP_ACCEPTED);
    }
}
