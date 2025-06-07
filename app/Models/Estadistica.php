<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadistica extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'estadisticas';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_estadistica';

    /**
     * Los atributos que son asignables.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo',
        'valor',
        'cantidad',
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
        'cantidad' => 'integer',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Obtiene todas las estadísticas por tipo.
     *
     * @param string $tipo
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function porTipo(string $tipo)
    {
        return self::where('tipo', $tipo)->orderByDesc('cantidad')->get();
    }

    /**
     * Actualiza o crea una estadística.
     *
     * @param string $tipo
     * @param string $valor
     * @param int $cantidad
     * @return Estadistica
     */
    public static function actualizarOCrear(string $tipo, string $valor, int $cantidad)
    {
        return self::updateOrCreate(
            ['tipo' => $tipo, 'valor' => $valor],
            ['cantidad' => $cantidad]
        );
    }

    /**
     * Incrementa la cantidad de una estadística.
     *
     * @param string $tipo
     * @param string $valor
     * @param int $incremento
     * @return Estadistica
     */
    public static function incrementar(string $tipo, string $valor, int $incremento = 1)
    {
        $estadistica = self::where('tipo', $tipo)
            ->where('valor', $valor)
            ->first();

        if ($estadistica) {
            $estadistica->cantidad += $incremento;
            $estadistica->save();
            return $estadistica;
        }

        return self::create([
            'tipo' => $tipo,
            'valor' => $valor,
            'cantidad' => $incremento,
        ]);
    }
} 