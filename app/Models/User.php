<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'username',
        'is_adm',
        'password',
        'email',
        'email_is_valid',
        'tokenEmailValidation',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function perfil()
    {
        return $this->hasOne(Perfil::class);
    }

    public function seguir()
    {
        return $this->hasMany(Seguir::class);
    }


    public function getSeguidoPeloUsuarioLogadoAttribute()
    {
        $usuarioLogado = auth()->user();
        if (!$usuarioLogado) return false;

        // O usuário atual possui um perfil.
        if (!$this->perfil) return false;

        return Seguir::where('user_id', $usuarioLogado->id) // seguidor = logado
            ->where('perfil_id', $this->perfil->id)        // seguido = este usuário (dono da notificação)
            ->exists();
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
