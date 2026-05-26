<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or update user
        $user = User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'administrator',
                'password' => bcrypt('abcd123456'),
            ]
        );

        // 2. Create or get role
        $role = Role::firstOrCreate([
            'name' => 'Administrator',
            
        ]);

        // 3. Sync all permissions to role (if exists)
        $permissions = Permission::pluck('name')->toArray();
        $role->syncPermissions($permissions);

        // 4. Assign role to user (IMPORTANT)
        $user->assignRole($role);

        // 5. Create employee profile (avoid duplicate)
        $employee = Employee::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => '',
                'latin_name' => '',
                'phone' => '',
                'position_id' => null,
            ]
        );

        // 6. Link relationship (only if needed)
        // $user->employee()->save($employee);
    }
}