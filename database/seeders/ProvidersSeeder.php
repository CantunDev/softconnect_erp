<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['category' => 'Proveedores', 'name' => 'create_providers']);
        Permission::create(['category' => 'Proveedores', 'name' => 'read_providers']);
        Permission::create(['category' => 'Proveedores', 'name' => 'update_providers']);
        Permission::create(['category' => 'Proveedores', 'name' => 'delete_providers']);

        $super_admin = Role::findByName('Super-Admin');
        $super_admin->givePermissionTo([
            'create_providers',
            'read_providers',
            'update_providers',
            'delete_providers'
            ]);
    }
}
