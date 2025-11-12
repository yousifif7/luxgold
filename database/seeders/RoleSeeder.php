<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $role = Role::firstOrCreate(['name' => 'admin']);
        $role1 = Role::firstOrCreate(['name' => 'provider']);
        $role2 = Role::firstOrCreate(['name' => 'parent']);
        $role2 = Role::firstOrCreate(['name' => 'moderator']);

        // Assign all existing permissions to superadmin
        $allPermissions = Permission::all();
        $role->syncPermissions($allPermissions);
    }
}
