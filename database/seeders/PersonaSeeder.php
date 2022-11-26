<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $persona = new Persona();
        $persona->nombre = "cliente";
        $persona->apellido = "uno";
        $persona->telefono = "09184714023";
        $persona->cedula = 12345678;
        $persona->nacionalidad = 'V';
        $persona->save();
    }
}
