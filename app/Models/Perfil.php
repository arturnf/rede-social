<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{   
    protected $fillable = [
        'img',
        'bio',
        'is_private',
        'user_id',
    ];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // 'user_id' é a chave estrangeira no perfil
    }

    public function seguir(){
        return $this->hasMany(Seguir::class, 'perfil_id');
    }
}
