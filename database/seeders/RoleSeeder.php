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
        $roleObs = Role::create(['name' => 'Observador']);
        $roleSoc = Role::create(['name' => 'Socio']);

        Permission::create([
            'name' => 'logs.index',
            'description' => 'Ver Bitacora',
        ])->syncRoles([$roleAdm, $roleSoc]);
        
        Permission::create([
            'name' => 'franquicias.index',
            'description' => 'Ver Franquicias',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);        
        Permission::create([
            'name' => 'franquicias.create',
            'description' => 'Crear Franquicia',
        ])->syncRoles([$roleAdm, $roleSoc]);        
        Permission::create([
            'name' => 'franquicias.edit',
            'description' => 'Editar Franquicia',
        ])->syncRoles([$roleAdm, $roleSoc]);
        Permission::create([
            'name' => 'franquicias.destroy',
            'description' => 'Eliminar Franquicia',
        ])->syncRoles([$roleAdm, $roleSoc]);
        
        Permission::create([
            'name' => 'users.index',
            'description' => 'Ver Usuarios',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);
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
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);        
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
            'name' => 'personas.index',
            'description' => 'Ver Clientes Personales',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);        
        Permission::create([
            'name' => 'personas.create',
            'description' => 'Crear Cliente Personal',
        ])->syncRoles([$roleAdm, $roleSoc]);        
        Permission::create([
            'name' => 'personas.edit',
            'description' => 'Editar Cliente Personal',
        ])->syncRoles([$roleAdm, $roleSoc]);
        Permission::create([
            'name' => 'personas.destroy',
            'description' => 'Eliminar Cliente Personal',
        ])->syncRoles([$roleAdm, $roleSoc]);
        
        Permission::create([
            'name' => 'empresas.index',
            'description' => 'Ver Clientes Empresariales',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);        
        Permission::create([
            'name' => 'empresas.create',
            'description' => 'Crear Cliente Empresarial',
        ])->syncRoles([$roleAdm, $roleSoc]);        
        Permission::create([
            'name' => 'empresas.edit',
            'description' => 'Editar Cliente Empresarial',
        ])->syncRoles([$roleAdm, $roleSoc]);
        Permission::create([
            'name' => 'empresas.destroy',
            'description' => 'Eliminar Cliente Empresarial',
        ])->syncRoles([$roleAdm, $roleSoc]);

        Permission::create([
            'name' => 'tags.index',
            'description' => 'Ver Etiquetas',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);        
        Permission::create([
            'name' => 'tags.create',
            'description' => 'Crear Etiqueta',
        ])->syncRoles([$roleAdm, $roleSoc]);        
        Permission::create([
            'name' => 'tags.edit',
            'description' => 'Editar Etiqueta',
        ])->syncRoles([$roleAdm, $roleSoc]);
        Permission::create([
            'name' => 'tags.destroy',
            'description' => 'Eliminar Etiqueta',
        ])->syncRoles([$roleAdm, $roleSoc]);
        
        Permission::create([
            'name' => 'productos.index',
            'description' => 'Ver Productos',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);        
        Permission::create([
            'name' => 'productos.create',
            'description' => 'Crear Producto',
        ])->syncRoles([$roleAdm, $roleSoc]);        
        Permission::create([
            'name' => 'productos.edit',
            'description' => 'Editar Producto',
        ])->syncRoles([$roleAdm, $roleSoc]);
        Permission::create([
            'name' => 'productos.destroy',
            'description' => 'Eliminar Producto',
        ])->syncRoles([$roleAdm, $roleSoc]);

        Permission::create([
            'name' => 'servicios.index',
            'description' => 'Ver Servicios',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);        
        Permission::create([
            'name' => 'servicios.create',
            'description' => 'Crear Servicio',
        ])->syncRoles([$roleAdm, $roleSoc]);        
        Permission::create([
            'name' => 'servicios.edit',
            'description' => 'Editar Servicio',
        ])->syncRoles([$roleAdm, $roleSoc]);
        Permission::create([
            'name' => 'servicios.destroy',
            'description' => 'Eliminar Servicio',
        ])->syncRoles([$roleAdm, $roleSoc]);

        Permission::create([
            'name' => 'visitas.index',
            'description' => 'Ver Hojas de Visitas',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);
        Permission::create([
            'name' => 'visitas.show',
            'description' => 'Ver detalles de Hoja de Visita',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);        
        Permission::create([
            'name' => 'visitas.create',
            'description' => 'Crear Hoja de Visita',
        ])->syncRoles([$roleAdm, $roleSoc]);        
        Permission::create([
            'name' => 'visitas.edit',
            'description' => 'Editar Hoja de Visita',
        ])->syncRoles([$roleAdm, $roleSoc]);
        Permission::create([
            'name' => 'visitas.destroy',
            'description' => 'Eliminar Hoja de Visita',
        ])->syncRoles([$roleAdm, $roleSoc]);
        
        Permission::create([
            'name' => 'entregas.index',
            'description' => 'Ver Notas de Entregas',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);
        Permission::create([
            'name' => 'entregas.show',
            'description' => 'Ver detalles de Nota de Entrega',
        ])->syncRoles([$roleAdm, $roleObs, $roleSoc]);        
        Permission::create([
            'name' => 'entregas.create',
            'description' => 'Crear Nota de Entrega',
        ])->syncRoles([$roleAdm, $roleSoc]);        
        Permission::create([
            'name' => 'entregas.edit',
            'description' => 'Editar Nota de Entrega',
        ])->syncRoles([$roleAdm, $roleSoc]);
        Permission::create([
            'name' => 'entregas.destroy',
            'description' => 'Eliminar Nota de Entrega',
        ])->syncRoles([$roleAdm, $roleSoc]);

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
