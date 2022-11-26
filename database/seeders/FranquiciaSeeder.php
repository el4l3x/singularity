<?php

namespace Database\Seeders;

use App\Models\Franquicia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FranquiciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $franquicia = new Franquicia();
        $franquicia->nombre = "singularity";
        $franquicia->slug = "singularity";
        $franquicia->actividad = "tecnologia";
        $franquicia->rif = "123456789";
        $franquicia->save();
    }
}
