<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /* protected $casts = [
        'created_at' => 'date:d-m-Y',
    ]; */

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
