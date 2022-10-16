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
            'description' => 'Crear Franquicias',
        ])->syncRoles([$roleAdm]);        
        Permission::create([
            'name' => 'franquicias.edit',
            'description' => 'Editar Franquicia',
        ])->syncRoles([$roleAdm]);
        Permission::create([
            'name' => 'franquicias.destroy',
            'description' => 'Eliminar Franquicia',
        ])->syncRoles([$roleAdm]);
    }
}
