<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresa = new Empresa();
        $empresa->nombre = "Empresa 1";
        $empresa->telefono = "1832397";
        $empresa->rif = "123456789";
        $empresa->tipo = "J";
        $empresa->save();
    }
}
