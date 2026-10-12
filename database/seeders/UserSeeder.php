<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'customer',
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                [
                    'name' => $role,
                    'guard_name' => 'web',
                ],
                []
            );
        }

        $customer = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Customer',
                'password' => Hash::make('password'),
            ]
        );

        $customer->assignRole('customer');

        $password = Hash::make('password');

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => $password,
            ]
        );

        $admin->assignRole('admin');

        Permission::updateOrCreate(
            ['name' => 'users.view'],
            [
                'name' => 'users.view',
            ]
        );

        Permission::updateOrCreate(
            ['name' => 'branches.view'],
            [
                'name' => 'branches.view',
            ]
        );

        $admin->syncPermissions(['users.view', 'branches.view']);
        $customer->syncPermissions(['users.view']);
    }
}
