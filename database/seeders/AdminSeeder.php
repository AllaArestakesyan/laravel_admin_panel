<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'edit users',
            'delete users',
            'view reports',
            'view admin',
            'edit admin',
            'delete admin',
            'manage roles',
            
            'view users',
            'edit content',
            'create skill',
            'view skill',
            'edit skill',
            'delete skill',

            'create job',
            'view job',
            'edit job',
            'delete job',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $manager = Role::create(['name' => 'manager', 'guard_name' => 'web']);

        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'view users',
            'edit content',
            'create skill',
            'view skill',
            'edit skill',
            'delete skill'
        ]);

        $manager->givePermissionTo([
            'view skill',
            'create job',
            'view job',
            'edit job',
            'delete job',
        ]);
    }
}
