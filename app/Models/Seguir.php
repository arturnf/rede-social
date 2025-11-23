<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguir extends Model
{
    protected $fillable = [
        'user_id',
        'perfil_id',
    ];
    use HasFactory;
}
