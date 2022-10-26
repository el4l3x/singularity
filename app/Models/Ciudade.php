<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudade extends Model
{
    use HasFactory;

    protected function nombre(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value),
            get: fn ($value) => ucfirst($value),
        );
    }

    public function direcciones()
    {
        return $this->hasMany(Direccione::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
