<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabla de usuarios (para administradores y clientes)
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->string('tipo_documento', 50);
            $table->string('numero_documento', 30)->unique();
            $table->string('genero', 20);
            $table->string('profesion', 100);
            $table->string('email')->unique();
            $table->string('telefono', 20);
            $table->string('password');
            $table->boolean('es_admin')->default(false);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->boolean('activo')->default(true);
        });

        // Tabla de categorías predefinidas
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->boolean('activo')->default(true);
        });

        // Tabla de preferencias de usuarios
        Schema::create('preferencias_usuarios', function (Blueprint $table) {
            $table->id('id_preferencia');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->string('hobby', 100);
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // Tabla de categorías de interés de los usuarios
        Schema::create('intereses_categorias', function (Blueprint $table) {
            $table->id('id_interes');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_categoria')->constrained('categorias', 'id_categoria')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['id_usuario', 'id_categoria'], 'unico_usuario_categoria');
        });

        // Tabla de especialidades de los usuarios
        Schema::create('especialidades_usuarios', function (Blueprint $table) {
            $table->id('id_especialidad');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_categoria')->constrained('categorias', 'id_categoria')->cascadeOnDelete();
            $table->text('descripcion');
            $table->integer('experiencia_anios')->default(0);
            $table->decimal('tarifa_hora', 10, 2)->default(0);
            $table->boolean('disponible')->default(true);
            $table->timestamps();
            $table->unique(['id_usuario', 'id_categoria'], 'unico_usuario_categoria_especialidad');
        });

        // Tabla de servicios ofrecidos
        Schema::create('servicios', function (Blueprint $table) {
            $table->id('id_servicio');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_categoria')->constrained('categorias', 'id_categoria')->cascadeOnDelete();
            $table->string('titulo', 255);
            $table->text('descripcion');
            $table->decimal('precio', 10, 2);
            $table->string('duracion_estimada', 50)->nullable();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });

        // Tabla de contactos/solicitudes de servicio
        Schema::create('solicitudes_servicios', function (Blueprint $table) {
            $table->id('id_solicitud');
            $table->foreignId('id_servicio')->constrained('servicios', 'id_servicio')->cascadeOnDelete();
            $table->foreignId('id_usuario_solicitante')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_usuario_proveedor')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->text('mensaje');
            $table->enum('estado', ['pendiente', 'aceptada', 'rechazada', 'completada', 'cancelada'])->default('pendiente');
            $table->timestamps();
        });

        // Tabla de valoraciones de servicios
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id('id_valoracion');
            $table->foreignId('id_solicitud')->constrained('solicitudes_servicios', 'id_solicitud')->cascadeOnDelete();
            $table->foreignId('id_usuario_evaluador')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->integer('puntuacion')->check('puntuacion BETWEEN 1 AND 5');
            $table->text('comentario')->nullable();
            $table->timestamp('fecha_valoracion')->useCurrent();
            $table->unique(['id_solicitud', 'id_usuario_evaluador'], 'unico_valoracion_solicitud');
        });

        // Tabla para datos estadísticos
        Schema::create('estadisticas', function (Blueprint $table) {
            $table->id('id_estadistica');
            $table->string('tipo', 50);
            $table->string('valor', 100);
            $table->integer('cantidad')->default(0);
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
        });

        // Tabla de mensajes entre usuarios
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id('id_mensaje');
            $table->foreignId('id_remitente')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_destinatario')->constrained('usuarios', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_solicitud')->nullable()->constrained('solicitudes_servicios', 'id_solicitud')->nullOnDelete();
            $table->text('contenido');
            $table->boolean('leido')->default(false);
            $table->timestamp('fecha_envio')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
        Schema::dropIfExists('estadisticas');
        Schema::dropIfExists('valoraciones');
        Schema::dropIfExists('solicitudes_servicios');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('especialidades_usuarios');
        Schema::dropIfExists('intereses_categorias');
        Schema::dropIfExists('preferencias_usuarios');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('usuarios');
    }
}; 