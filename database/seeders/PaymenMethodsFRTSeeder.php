<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PaymenMethodsFRTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['category' => 'Cuentas', 'name' => 'create_accounts']);
        Permission::create(['category' => 'Cuentas', 'name' => 'read_accounts']);
        Permission::create(['category' => 'Cuentas', 'name' => 'update_accounts']);
        Permission::create(['category' => 'Cuentas', 'name' => 'delete_accounts']);

        $super_admin = Role::findByName('Super-Admin');
        $super_admin->givePermissionTo([
            'create_accounts',
            'read_accounts',
            'update_accounts',
            'delete_accounts'
            ]);
    }
}
