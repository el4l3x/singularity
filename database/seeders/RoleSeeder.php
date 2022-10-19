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
     *
     * @return void
     */
    public function run()
    {
        $roleAdm = Role::create(['name' => 'Admin']);

        Permission::create([
            'name' => 'logs.index',
            'description' => 'Ver Bitacora',
        ])->syncRoles([$roleAdm]);
        
        Permission::create([
            'name' => 'franquicias.index',
            'description' => 'Ver Franquicias',
        ])->syncRoles([$roleAdm]);        
        Permission::create([
            'name' => 'franquicias.create',
            'description' => 'Crear Franquicia',
        ])->syncRoles([$roleAdm]);        
        Permission::create([
            'name' => 'franquicias.edit',
            'description' => 'Editar Franquicia',
        ])->syncRoles([$roleAdm]);
        Permission::create([
            'name' => 'franquicias.destroy',
            'description' => 'Eliminar Franquicia',
        ])->syncRoles([$roleAdm]);
        
        Permission::create([
            'name' => 'users.index',
            'description' => 'Ver Usuarios',
        ])->syncRoles([$roleAdm]);        
        Permission::create([
            'name' => 'users.create',
            'description' => 'Crear Usuario',
        ])->syncRoles([$roleAdm]);        
        Permission::create([
            'name' => 'users.edit',
            'description' => 'Editar Usuario',
        ])->syncRoles([$roleAdm]);
        Permission::create([
            'name' => 'users.destroy',
            'description' => 'Eliminar Usuario',
        ])->syncRoles([$roleAdm]);
        
        Permission::create([
            'name' => 'roles.index',
            'description' => 'Ver Roles',
        ])->syncRoles([$roleAdm]);        
        Permission::create([
            'name' => 'roles.create',
            'description' => 'Crear Rol',
        ])->syncRoles([$roleAdm]);        
        Permission::create([
            'name' => 'roles.edit',
            'description' => 'Editar Rol',
        ])->syncRoles([$roleAdm]);
        Permission::create([
            'name' => 'roles.destroy',
            'description' => 'Eliminar Rol',
        ])->syncRoles([$roleAdm]);

        Permission::create([
            'name' => 'cobros.index',
            'description' => 'Ver cuentas por cobrar',
        ])->syncRoles([$roleAdm]);        
        Permission::create([
            'name' => 'cobros.create',
            'description' => 'Crear cuenta por cobrar',
        ])->syncRoles([$roleAdm]);        
        Permission::create([
            'name' => 'cobros.edit',
            'description' => 'Editar cuenta por cobrar',
        ])->syncRoles([$roleAdm]);
        Permission::create([
            'name' => 'cobros.destroy',
            'description' => 'Eliminar cuenta por cobrar',
        ])->syncRoles([$roleAdm]);
    }
}
