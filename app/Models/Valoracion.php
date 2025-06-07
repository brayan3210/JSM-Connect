<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'valoraciones';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_valoracion';

    /**
     * Los atributos que son asignables.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_solicitud',
        'id_usuario_evaluador',
        'puntuacion',
        'comentario',
    ];

    /**
     * Indica que no se utilizarán los timestamps de created_at y updated_at.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'puntuacion' => 'integer',
        'fecha_valoracion' => 'datetime',
    ];

    /**
     * Obtiene la solicitud de servicio que recibió esta valoración.
     */
    public function solicitud()
    {
        return $this->belongsTo(SolicitudServicio::class, 'id_solicitud');
    }

    /**
     * Obtiene el usuario que realizó la valoración.
     */
    public function evaluador()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_evaluador');
    }
} 