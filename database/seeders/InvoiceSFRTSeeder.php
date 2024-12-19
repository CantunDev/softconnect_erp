<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class InvoiceSFRTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['category' => 'Facturas', 'name' => 'create_invoices']);
        Permission::create(['category' => 'Facturas', 'name' => 'read_invoices']);
        Permission::create(['category' => 'Facturas', 'name' => 'update_invoices']);
        Permission::create(['category' => 'Facturas', 'name' => 'delete_invoices']);

        $super_admin = Role::findByName('Super-Admin');
        $super_admin->givePermissionTo([
            'create_invoices',
            'read_invoices',
            'update_invoices',
            'delete_invoices'
            ]);
    }
}
