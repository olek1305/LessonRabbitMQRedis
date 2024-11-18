<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::all();

        $admin = Role::where('name', 'admin')->first();
        if ($admin) {
            $admin->permissions()->sync($permissions->pluck('id')->toArray());
        }

        $editor = Role::where('name', 'editor')->first();
        if ($editor) {
            $editor->permissions()->sync(
                $permissions->filter(fn($permission) => $permission->name !== 'edit_roles')->pluck('id')->toArray()
            );
        }

        $viewerRoles = [
            'view_users',
            'view_roles',
            'view_products',
            'view_orders',
        ];

        $viewer = Role::where('name', 'viewer')->first();
        if ($viewer) {
            $viewer->permissions()->sync(
                $permissions->filter(fn($permission) => in_array($permission->name, $viewerRoles))->pluck('id')->toArray()
            );
        }
    }
}
