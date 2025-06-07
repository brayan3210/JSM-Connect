<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'categorias';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_categoria';

    /**
     * Los atributos que son asignables.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Obtiene los usuarios que están interesados en esta categoría.
     */
    public function usuariosInteresados()
    {
        return $this->belongsToMany(Usuario::class, 'intereses_categorias', 'id_categoria', 'id_usuario')
            ->withTimestamps();
    }

    /**
     * Obtiene los usuarios que tienen especialidad en esta categoría.
     */
    public function usuariosEspecialistas()
    {
        return $this->belongsToMany(Usuario::class, 'especialidades_usuarios', 'id_categoria', 'id_usuario')
            ->withPivot('descripcion', 'experiencia_anios', 'tarifa_hora', 'disponible')
            ->withTimestamps();
    }

    /**
     * Obtiene los servicios de esta categoría.
     */
    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'id_categoria');
    }
} 