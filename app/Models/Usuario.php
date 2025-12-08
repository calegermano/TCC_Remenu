<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\VerificarEmailCustomizado;
use App\Notifications\ResetarSenhaCustomizada;

class Usuario extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'tipo_id',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function tipo()
    {
        return $this->belongsTo(TipoUsuario::class, 'tipo_id');
    }

    public function isAdmin()
    {
        // Verificação simples e direta
        return $this->tipo_id === 1;
    }

    public function isComum()
    {
        return $this->tipo_id === 2;
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'usuario_id');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerificarEmailCustomizado);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetarSenhaCustomizada($token));
    }
}