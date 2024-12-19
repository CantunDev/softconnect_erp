<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ExpensesSFRTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['category' => 'Gastos', 'name' => 'create_expenses']);
        Permission::create(['category' => 'Gastos', 'name' => 'read_expenses']);
        Permission::create(['category' => 'Gastos', 'name' => 'update_expenses']);
        Permission::create(['category' => 'Gastos', 'name' => 'delete_expenses']);

        $super_admin = Role::findByName('Super-Admin');
        $super_admin->givePermissionTo([
            'create_expenses',
            'read_expenses',
            'update_expenses',
            'delete_expenses'
            ]);
    }
}
