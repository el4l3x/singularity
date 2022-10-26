<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccione extends Model
{
    use HasFactory;

    public function direccioneable()
    {
        return $this->morphTo();
    }

    public function ciudade()
    {
        return $this->belongsTo(Ciudade::class);
    }
}
