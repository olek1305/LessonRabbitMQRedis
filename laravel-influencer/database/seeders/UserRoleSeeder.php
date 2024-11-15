<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $defaultRole = Role::where('name', 'viewer')->first();

        if (!$defaultRole) {
            $this->command->info('Nie znaleziono roli "viewer".');
            return;
        }

        // Pobierz wszystkich użytkowników bez przypisanej roli
        $usersWithoutRoles = User::doesntHave('roles')->get();

        foreach ($usersWithoutRoles as $user) {
            DB::table('user_roles')->insert([
                'user_id' => $user->id,
                'role_id' => $defaultRole->id,
            ]);
        }
    }
}
