<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function visitable()
    {
        return $this->morphTo();
    }

    public function servicios()
    {
        return $this->morphedByMany(Servicio::class, 'visitable');
    }

    public function productos()
    {
        return $this->morphedByMany(Producto::class, 'visitable');
    }

    public function franquicia()
    {
        return $this->belongsTo(Franquicia::class);
    }
}
