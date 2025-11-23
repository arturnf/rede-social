<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'perfil_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // 'user_id' é a chave estrangeira no perfil
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }
}
