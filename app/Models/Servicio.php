<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Servicio extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'servicios';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_servicio';

    /**
     * Los atributos que son asignables.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_usuario',
        'id_categoria',
        'titulo',
        'descripcion',
        'tipo_intercambio',
        'descripcion_intercambio',
        'duracion_estimada',
        'duracion_dias',
        'fecha_expiracion',
        'disponible',
        'expirado',
    ];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'disponible' => 'boolean',
        'expirado' => 'boolean',
        'duracion_dias' => 'integer',
        'fecha_expiracion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot del modelo para configurar eventos
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($servicio) {
            // Establecer fecha de expiración al crear el servicio
            $duracionDias = (int) $servicio->duracion_dias;
            if ($duracionDias > 0) {
                $servicio->fecha_expiracion = Carbon::now()->addDays($duracionDias);
            } else {
                $servicio->fecha_expiracion = null; // Sin límite de tiempo
            }
        });
        
        static::updating(function ($servicio) {
            // Actualizar fecha de expiración si se cambia la duración
            if ($servicio->isDirty('duracion_dias')) {
                $duracionDias = (int) $servicio->duracion_dias;
                if ($duracionDias > 0) {
                    // Recalcular desde la fecha de creación original para mantener la duración exacta
                    $servicio->fecha_expiracion = Carbon::parse($servicio->created_at)->addDays($duracionDias);
                    $servicio->expirado = false; // Resetear estado de expirado
                } else {
                    $servicio->fecha_expiracion = null; // Sin límite de tiempo
                    $servicio->expirado = false;
                }
            }
        });
    }

    /**
     * Verificar si el servicio ha expirado
     */
    public function hasExpired()
    {
        if (!$this->fecha_expiracion) {
            return false;
        }
        
        return Carbon::now()->greaterThan($this->fecha_expiracion);
    }

    /**
     * Marcar servicio como expirado
     */
    public function markAsExpired()
    {
        $this->update([
            'expirado' => true,
            'disponible' => false
        ]);
    }

    /**
     * Obtener días restantes hasta la expiración
     */
    public function getDaysUntilExpiration()
    {
        if (!$this->fecha_expiracion) {
            return null;
        }
        
        $now = Carbon::now();
        $expiration = Carbon::parse($this->fecha_expiracion);
        
        if ($expiration->isPast()) {
            return 0;
        }
        
        return $now->diffInDays($expiration);
    }

    /**
     * Scope para servicios no expirados
     */
    public function scopeActive($query)
    {
        return $query->where('expirado', false)
                    ->where('disponible', true)
                    ->where(function($q) {
                        $q->whereNull('fecha_expiracion')
                          ->orWhere('fecha_expiracion', '>', Carbon::now());
                    });
    }

    /**
     * Scope para servicios expirados
     */
    public function scopeExpired($query)
    {
        return $query->where('expirado', true)
                    ->orWhere('fecha_expiracion', '<=', Carbon::now());
    }

    /**
     * Obtiene el usuario que ofrece este servicio.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Obtiene la categoría a la que pertenece este servicio.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    /**
     * Get the requests for this service.
     */
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_servicio', 'id_servicio');
    }
} 