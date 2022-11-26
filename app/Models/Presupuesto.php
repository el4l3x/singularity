<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function presupuestoable()
    {
        return $this->morphTo();
    }

    public function servicios()
    {
        return $this->morphedByMany(Servicio::class, 'presupuestoable')->withPivot('cantidad', 'precio', 'descripcion');
    }

    public function productos()
    {
        return $this->morphedByMany(Producto::class, 'presupuestoable')->withPivot('cantidad', 'precio', 'descripcion');
    }

    public function franquicia()
    {
        return $this->belongsTo(Franquicia::class);
    }
}
