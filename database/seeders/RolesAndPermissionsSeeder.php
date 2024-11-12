<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'manage-roles']);
        Permission::create(['name' => 'manage-permissions']);
        Permission::create(['name' => 'manage-group']);
        Permission::create(['name' => 'manage-product']);
        Permission::create(['name' => 'manage-export']);
        Permission::create(['name' => 'manage-exporter']);
        Permission::create(['name' => 'manage-import']);
        Permission::create(['name' => 'manage-importer']);

        Permission::create(['name' => 'block']);
        Permission::create(['name' => 'activate']);

        $adminRole = Role::create(['name' => 'Admin']);
        $notAdminRole = Role::create(['name' => 'notAdmin']);

        $adminRole->givePermissionTo(Permission::all());
        $notAdminRole->givePermissionTo(['manage-group','manage-export','manage-exporter','manage-import','manage-importer',]);

    }
}