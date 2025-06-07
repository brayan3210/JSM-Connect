<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'solicitudes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_solicitud';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_servicio',
        'id_usuario_solicitante',
        'id_usuario_proveedor',
        'mensaje',
        'fecha_deseada',
        'estado',
        'comentario_estado',
        'puntuacion',
        'comentario_valoracion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha_deseada' => 'datetime',
        'puntuacion' => 'integer',
    ];

    /**
     * Get the service associated with the request.
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    /**
     * Get the user who made the request.
     */
    public function usuario_solicitante()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_solicitante', 'id_usuario');
    }

    /**
     * Get the service provider.
     */
    public function usuario_proveedor()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_proveedor', 'id_usuario');
    }
} 