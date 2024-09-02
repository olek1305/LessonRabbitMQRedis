<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection<Role> The collection of roles.
     */
    public function index(): Collection
    {
        return Role::all();
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

        return response()->json($role, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id The ID of the role to display.
     * @return Role The role with the specified ID.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(string $id): Role
    {
        return Role::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request The request containing updated role data.
     * @param string $id The ID of the role to update.
     * @return JsonResponse The response with the updated role.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        $role->update($request->only('name'));

        return response()->json($role, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id The ID of the role to delete.
     * @return JsonResponse The response indicating successful deletion.
     */
    public function destroy(string $id): JsonResponse
    {
        Role::destroy($id);

        return response()->json([
            'message' => 'Role got deleted',
            'id' => $id
        ], 200);
    }
}
