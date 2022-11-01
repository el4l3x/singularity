<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tag = new Tag();
        $tag->nombre = "Servicio Tecnico";
        $tag->save();

        $tag = new Tag();
        $tag->nombre = "Informatica";
        $tag->save();

        $tag = new Tag();
        $tag->nombre = "Mantenimiento";
        $tag->save();

        $tag = new Tag();
        $tag->nombre = "Reparacion";
        $tag->save();

        $tag = new Tag();
        $tag->nombre = "Computadora";
        $tag->save();

        $tag = new Tag();
        $tag->nombre = "Servidor";
        $tag->save();

        $tag = new Tag();
        $tag->nombre = "Redes";
        $tag->save();

        $tag = new Tag();
        $tag->nombre = "CCTV";
        $tag->save();

        $tag = new Tag();
        $tag->nombre = "Personalizacion";
        $tag->save();
    }
}
