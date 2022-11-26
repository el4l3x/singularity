<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    public function visitas()
    {
        return $this->morphToMany(Visita::class, 'visitable');
    }
    
    public function entregas()
    {
        return $this->morphToMany(Entrega::class, 'entregable');
    }

    public function presupuestos()
    {
        return $this->morphToMany(Presupuesto::class, 'presupuestoable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value),
        );
    }
}
