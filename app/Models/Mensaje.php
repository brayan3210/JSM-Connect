<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mensajes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_mensaje';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_remitente',
        'id_destinatario',
        'contenido',
        'fecha_envio',
        'leido',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha_envio' => 'datetime',
        'leido' => 'boolean',
    ];

    /**
     * Get the user who sent the message.
     */
    public function remitente()
    {
        return $this->belongsTo(Usuario::class, 'id_remitente', 'id_usuario');
    }

    /**
     * Get the recipient user.
     */
    public function destinatario()
    {
        return $this->belongsTo(Usuario::class, 'id_destinatario', 'id_usuario');
    }

    /**
     * Obtiene la solicitud de servicio relacionada con este mensaje, si existe.
     */
    public function solicitud()
    {
        return $this->belongsTo(SolicitudServicio::class, 'id_solicitud');
    }
} 