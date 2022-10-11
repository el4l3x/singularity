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
            'name' => 'posts.index',
            'description' => 'Ver Noticias Publicadas',
        ])->syncRoles([$roleAdm]);
    }
}
