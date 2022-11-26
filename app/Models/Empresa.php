<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    public function visitas()
    {
        return $this->morphMany(Visita::class, 'visitable');
    }

    public function entregas()
    {
        return $this->morphMany(Entrega::class, 'entregable');
    }

    public function presupuestos()
    {
        return $this->morphMany(Presupuesto::class, 'presupuestoable');
    }
    
    public function facturas()
    {
        return $this->morphMany(Factura::class, 'facturable');
    }

    public function direccion()
    {
        return $this->morphOne(Direccione::class, 'direccioneable');
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value),
        );
    }
}
