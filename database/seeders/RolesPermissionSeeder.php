<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // USUARIOS
        Permission::create([ 'category' => 'Usuarios', 'name' => 'create_users']);
        Permission::create([ 'category' => 'Usuarios', 'name' => 'read_users']);
        Permission::create([ 'category' => 'Usuarios', 'name' => 'update_users']);
        Permission::create([ 'category' => 'Usuarios', 'name' => 'delete_users']);
        // ROLES
        Permission::create([ 'category' => 'Roles', 'name' => 'create_roles']);
        Permission::create([ 'category' => 'Roles', 'name' => 'read_roles']);
        Permission::create([ 'category' => 'Roles', 'name' => 'update_roles']);
        Permission::create([ 'category' => 'Roles', 'name' => 'delete_roles']);
        // PERMISOS
        Permission::create([ 'category' => 'Permisos','name' => 'create_permissions']);
        Permission::create([ 'category' => 'Permisos', 'name' => 'read_permissions']);
        Permission::create([ 'category' => 'Permisos', 'name' => 'update_permissions']);
        Permission::create([ 'category' => 'Permisos', 'name' => 'delete_permissions']);
        // EMPRESAS
        Permission::create([ 'category' => 'Empresas','name' => 'create_business']);
        Permission::create([ 'category' => 'Empresas', 'name' => 'read_business']);
        Permission::create([ 'category' => 'Empresas', 'name' => 'update_business']);
        Permission::create([ 'category' => 'Empresas', 'name' => 'delete_business']);
        // RESTAURANTES
        Permission::create([ 'category' => 'Restaurantes','name' => 'create_restaurants']);
        Permission::create([ 'category' => 'Restaurantes', 'name' => 'read_restaurants']);
        Permission::create([ 'category' => 'Restaurantes', 'name' => 'update_restaurants']);
        Permission::create([ 'category' => 'Restaurantes', 'name' => 'delete_restaurants']);

        $sa = Role::create(['name' => 'Super-Admin']);
        $sa->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'Administrador']);
        $admin->givePermissionTo('read_users');
        $admin->givePermissionTo('create_users');
        $admin->givePermissionTo('update_users');
        $admin->givePermissionTo('delete_users');

        $operator = Role::create(['name' => 'Operador']);

            $bc = User::factory()->create([
            'name' => 'Bernabe',
            'lastname' => 'Cantun',
            'surname' => 'Dominguez',
            'email' => 'cantunberna@gmail.com',
            'password' => bcrypt('Cantun97.-'),
            'phone' => '938 134 7504',
            ]);
            $bc->assignRole($sa);


            $js = User::factory()->create([
            'name' => 'Jesus Arturo',
            'lastname' => 'Carmona',
            'surname' => 'Aguirre',
            'email' => 'jessarturo97@gmail.com',
            'password' => bcrypt('Carmona97.-'),
            ]);
            $js->assignRole($sa);

    }
}
