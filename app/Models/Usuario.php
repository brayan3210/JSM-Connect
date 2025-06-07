<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_usuario';

    /**
     * Indica que no se utilizarán los timestamps de created_at y updated_at.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Los atributos que son asignables.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'genero',
        'profesion',
        'email',
        'telefono',
        'password',
        'es_admin',
        'activo',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'es_admin' => 'boolean',
        'activo' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    /**
     * Determina si el usuario es administrador.
     *
     * @return bool
     */
    public function esAdmin()
    {
        return $this->es_admin;
    }

    /**
     * Relación con preferencias del usuario
     */
    public function preferencias()
    {
        return $this->hasMany(PreferenciaUsuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con categorías de interés
     */
    public function intereses()
    {
        return $this->belongsToMany(Categoria::class, 'intereses_categorias', 'id_usuario', 'id_categoria');
    }

    /**
     * Relación con categorías de especialidad
     */
    public function especialidades()
    {
        return $this->belongsToMany(Categoria::class, 'especialidades_usuarios', 'id_usuario', 'id_categoria')
            ->withPivot(['descripcion', 'experiencia_anios', 'tarifa_hora', 'disponible', 'id_especialidad'])
            ->withTimestamps();
    }

    /**
     * Obtiene los servicios ofrecidos por el usuario.
     */
    public function serviciosOfrecidos()
    {
        return $this->hasMany(Servicio::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Obtiene las solicitudes realizadas por el usuario.
     */
    public function solicitudesRealizadas()
    {
        return $this->hasMany(Solicitud::class, 'id_usuario_solicitante', 'id_usuario');
    }

    /**
     * Obtiene las solicitudes recibidas por el usuario.
     */
    public function solicitudesRecibidas()
    {
        return $this->hasMany(Solicitud::class, 'id_usuario_proveedor', 'id_usuario');
    }

    /**
     * Obtiene las valoraciones hechas por el usuario.
     */
    public function valoracionesHechas()
    {
        return $this->hasMany(Valoracion::class, 'id_usuario_evaluador');
    }

    /**
     * Obtiene las valoraciones recibidas como proveedor.
     */
    public function valoracionesRecibidas()
    {
        return $this->hasManyThrough(
            Valoracion::class,
            SolicitudServicio::class,
            'id_usuario_proveedor',
            'id_solicitud',
            'id_usuario',
            'id_solicitud'
        );
    }

    /**
     * Obtiene los mensajes enviados por el usuario.
     */
    public function mensajesEnviados()
    {
        return $this->hasMany(Mensaje::class, 'id_remitente', 'id_usuario');
    }

    /**
     * Obtiene los mensajes recibidos por el usuario.
     */
    public function mensajesRecibidos()
    {
        return $this->hasMany(Mensaje::class, 'id_destinatario', 'id_usuario');
    }

    /**
     * Obtiene los logs de actividad del usuario.
     */
    public function logs()
    {
        return $this->hasMany(Log::class, 'id_usuario', 'id_usuario');
    }
} 