<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PurchasesSFRTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['category' => 'Compras', 'name' => 'create_purchases']);
        Permission::create(['category' => 'Compras', 'name' => 'read_purchases']);
        Permission::create(['category' => 'Compras', 'name' => 'update_purchases']);
        Permission::create(['category' => 'Compras', 'name' => 'delete_purchases']);

        $super_admin = Role::findByName('Super-Admin');
        $super_admin->givePermissionTo([
            'create_purchases',
            'read_purchases',
            'update_purchases',
            'delete_purchases'
            ]);
    }
}
