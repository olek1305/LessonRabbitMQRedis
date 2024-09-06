<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection The collection of roles.
     */
    public function index(): AnonymousResourceCollection
    {
        return RoleResource::collection(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request The request containing role data.
     * @return JsonResponse The response with the created role.
     */
    public function store(Request $request): JsonResponse
    {
        $role = Role::create($request->only('name'));

        if ($permissions = $request->input('permissions')) {
            $role->permissions()->sync($permissions);
        }

        return response()->json(new RoleResource($role), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id The ID of the role to display.
     * @return RoleResource The role with the specified ID.
     *
     * @throws ModelNotFoundException
     */
    public function show(string $id): RoleResource
    {
        return new RoleResource(Role::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request The request containing updated role data.
     * @param string $id The ID of the role to update.
     * @return JsonResponse The response with the updated role.
     *
     * @throws ModelNotFoundException
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        $role->update($request->only('name'));

        DB::table('role_permission')->where('role_id', $role->id)->delete();


        if ($permissions = $request->input('permissions')) {
            $role->permissions()->sync($permissions);
        }

        return response()->json(new RoleResource(($role), 202));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id The ID of the role to delete.
     * @return JsonResponse The response indicating successful deletion.
     */
    public function destroy(string $id): JsonResponse
    {
        DB::table('role_permission')->where('role_id', $id)->delete();

        $role = Role::findOrFail($id);

        $role->delete();

        return response()->json([
            'message' => 'Role got deleted',
            'role' => new RoleResource($role)
        ], 200);
    }
}
