<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudServicio extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'solicitudes_servicios';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_solicitud';

    /**
     * Los atributos que son asignables.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_servicio',
        'id_usuario_solicitante',
        'id_usuario_proveedor',
        'mensaje',
        'estado',
        'fecha_deseada',
        'comentario_estado',
        'puntuacion',
        'comentario_valoracion',
    ];

    /**
     * Obtiene el servicio de esta solicitud.
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    /**
     * Obtiene el usuario que solicitó el servicio.
     */
    public function solicitante()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_solicitante');
    }

    /**
     * Alias para solicitante para mantener compatibilidad
     */
    public function usuario_solicitante()
    {
        return $this->solicitante();
    }

    /**
     * Obtiene el usuario que provee el servicio.
     */
    public function proveedor()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_proveedor');
    }

    /**
     * Alias para proveedor para mantener compatibilidad
     */
    public function usuario_proveedor()
    {
        return $this->proveedor();
    }

    /**
     * Obtiene las valoraciones de esta solicitud.
     */
    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class, 'id_solicitud');
    }

    /**
     * Obtiene los mensajes relacionados con esta solicitud.
     */
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'id_solicitud');
    }
} 