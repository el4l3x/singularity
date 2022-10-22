<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    public function visitas()
    {
        return $this->morphMany(Visita::class, 'visitable');
    }

    public function direcciones()
    {
        return $this->morphOne(Direccione::class, 'direccioneable');
    }
}
