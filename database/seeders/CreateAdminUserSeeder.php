<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $user = User::create([
        //     'name' => 'administrator',
        //     'email' => 'admin@email.com',
        //     'password' => bcrypt('abcd123456')
        // ]);
        $user = User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'administrator',
                'password' => bcrypt('abcd123456')
            ]
        );


        // $role = Role::create(['name' => 'Administrator']);
        $role = Role::firstOrCreate([
            'name' => 'Administrator'
        ]);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        //  Creates the user profile
        //  $employee = Employee::create([
        //   'user_id' => $user->id,
        //   'name' => '',
        //   'latin_name' => '',
        //   'phone' => '',
        //   'position_id' => $role->id
        // ]);
        Employee::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => '',
                'latin_name' => '',
                'phone' => '',
                'position_id' => $role->id
            ]
        );



        // $user->employee()->save($employee);
    }
}
