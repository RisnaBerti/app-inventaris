<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    //     $roleAdmin = Role::create(['name' => 'Admin']);

    //     foreach (config('permission.permissions') as $permission) {
    //         foreach ($permission['access'] as $access) {
    //             Permission::create(['name' => $access]);
    //         }
    //     }

    //     $userAdmin = User::first();
    //     $userAdmin->assignRole('admin');
    //     $roleAdmin->givePermissionTo(Permission::all());
    // }

    public function run(): void
    {
        // Forget cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create or retrieve the Admin role
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);

        // Define the permissions for the laporans group
        $laporansPermissions = ['transak label'];

        // Create permissions for the laporans group if they don't already exist
        foreach ($laporansPermissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Assign the new permissions to the Admin role
        $roleAdmin->givePermissionTo($laporansPermissions);

        // Retrieve the first user
        $userAdmin = User::first();
        if ($userAdmin) {
            // Assign the Admin role to the first user
            $userAdmin->assignRole('Admin');
        }
    }
}
