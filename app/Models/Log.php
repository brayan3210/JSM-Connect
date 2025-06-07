<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_usuario',
        'accion',
        'descripcion',
        'ip_address',
        'user_agent',
        'url',
        'metodo_http',
        'parametros',
        'tipo'
    ];

    protected $casts = [
        'parametros' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Scopes para filtrar por tipo
    public function scopeInfo($query)
    {
        return $query->where('tipo', 'info');
    }

    public function scopeWarning($query)
    {
        return $query->where('tipo', 'warning');
    }

    public function scopeError($query)
    {
        return $query->where('tipo', 'error');
    }

    public function scopeSuccess($query)
    {
        return $query->where('tipo', 'success');
    }

    // Método para crear un log
    public static function crearLog($idUsuario, $accion, $descripcion = null, $tipo = 'info', $parametros = null)
    {
        return self::create([
            'id_usuario' => $idUsuario,
            'accion' => $accion,
            'descripcion' => $descripcion,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'metodo_http' => request()->method(),
            'parametros' => $parametros,
            'tipo' => $tipo
        ]);
    }
} 