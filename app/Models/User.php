<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'password',
        'user_level',
        'image',
        'status',
        'last_login',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];

    // Constantes para niveles de usuario
    const LEVEL_ADMIN = 1;
    const LEVEL_BODEGA = 2;
    const LEVEL_USUARIO = 3;

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin(): bool
    {
        return $this->user_level === self::LEVEL_ADMIN;
    }

    /**
     * Verificar si el usuario está activo
     */
    public function isActive(): bool
    {
        return $this->status === 1;
    }

    /**
     * Obtener el nombre del nivel de usuario
     */
    public function getUserLevelName(): string
    {
        return match($this->user_level) {
            self::LEVEL_ADMIN => 'Administrador',
            self::LEVEL_BODEGA => 'Bodega',
            self::LEVEL_USUARIO => 'Usuario',
            default => 'Desconocido',
        };
    }
}
