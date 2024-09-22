<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserRole;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController
{
    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('view', 'users');

        $users = User::paginate();

        return UserResource::collection($users);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(int $id): UserResource
    {
        Gate::authorize('view', 'users');

        $user = User::find($id);

        return new UserResource($user);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(UserCreateRequest $request): ResponseFactory|Application|Response
    {
        Gate::authorize('edit', 'users');

        $user = User::create($request->only('first_name', 'last_name', 'email', 'role_id') + [
            'password' => bcrypt($request->input('password')),
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->input('role_id'),
        ]);

        return response($user, 202);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UserUpdateRequest $request, User $user): Application|Response|ResponseFactory
    {
        Gate::authorize('edit', 'users');

        $user->update($request->only('first_name', 'last_name', 'email'));

        UserRole::where('user_id', $user->id)->delete();

        UserRole::updated([
            'user_id' => $user->id,
            'role_id' => $request->input('role_id'),
        ]);

        return response(new UserResource($user), 202);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $id): Application|Response|ResponseFactory
    {
        Gate::authorize('edit', 'users');

        User::destroy($id);

        return response(null, 202);
    }
}
