<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ChecksSFRTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['category' => 'Cheques', 'name' => 'create_checks']);
        Permission::create(['category' => 'Cheques', 'name' => 'read_checks']);
        Permission::create(['category' => 'Cheques', 'name' => 'update_checks']);
        Permission::create(['category' => 'Cheques', 'name' => 'delete_checks']);

        $super_admin = Role::findByName('Super-Admin');
        $super_admin->givePermissionTo([
            'create_checks',
            'read_checks',
            'update_checks',
            'delete_checks'
            ]);
    }
}
