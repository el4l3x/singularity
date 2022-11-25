<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function entregable()
    {
        return $this->morphTo();
    }

    public function servicios()
    {
        return $this->morphedByMany(Servicio::class, 'entregable')->withPivot('cantidad', 'precio', 'descripcion');
    }

    public function productos()
    {
        return $this->morphedByMany(Producto::class, 'entregable')->withPivot('cantidad', 'precio', 'descripcion');
    }

    public function franquicia()
    {
        return $this->belongsTo(Franquicia::class);
    }
}
