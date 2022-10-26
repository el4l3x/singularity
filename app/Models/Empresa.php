<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    public function visitas()
    {
        return $this->morphMany(Visita::class, 'visitable');
    }

    public function direcciones()
    {
        return $this->morphMany(Direccione::class, 'direccioneable');
    }
}
