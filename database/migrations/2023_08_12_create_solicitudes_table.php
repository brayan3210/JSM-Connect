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
        if (!Schema::hasTable('solicitudes')) {
            Schema::create('solicitudes', function (Blueprint $table) {
                $table->id('id_solicitud');
                $table->unsignedBigInteger('id_servicio');
                $table->unsignedBigInteger('id_usuario_solicitante');
                $table->unsignedBigInteger('id_usuario_proveedor');
                $table->text('mensaje');
                $table->dateTime('fecha_deseada')->nullable();
                $table->enum('estado', ['pendiente', 'aceptada', 'rechazada', 'completada', 'cancelada'])->default('pendiente');
                $table->text('comentario_estado')->nullable();
                $table->integer('puntuacion')->nullable();
                $table->text('comentario_valoracion')->nullable();
                $table->timestamps();
    
                $table->foreign('id_servicio')->references('id_servicio')->on('servicios');
                $table->foreign('id_usuario_solicitante')->references('id_usuario')->on('usuarios');
                $table->foreign('id_usuario_proveedor')->references('id_usuario')->on('usuarios');
            });
        } else {
            Schema::table('solicitudes', function (Blueprint $table) {
                // Add any missing columns
                if (!Schema::hasColumn('solicitudes', 'fecha_deseada')) {
                    $table->dateTime('fecha_deseada')->nullable();
                }
                
                if (!Schema::hasColumn('solicitudes', 'comentario_estado')) {
                    $table->text('comentario_estado')->nullable();
                }
                
                if (!Schema::hasColumn('solicitudes', 'puntuacion')) {
                    $table->integer('puntuacion')->nullable();
                }
                
                if (!Schema::hasColumn('solicitudes', 'comentario_valoracion')) {
                    $table->text('comentario_valoracion')->nullable();
                }
                
                if (!Schema::hasColumn('solicitudes', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to drop the table if it already existed
        // Just remove the columns we added
        if (Schema::hasTable('solicitudes')) {
            Schema::table('solicitudes', function (Blueprint $table) {
                $columnsToCheck = [
                    'fecha_deseada',
                    'comentario_estado',
                    'puntuacion',
                    'comentario_valoracion',
                    'created_at',
                    'updated_at'
                ];
                
                $columnsToRemove = [];
                foreach ($columnsToCheck as $column) {
                    if (Schema::hasColumn('solicitudes', $column)) {
                        $columnsToRemove[] = $column;
                    }
                }
                
                if (!empty($columnsToRemove)) {
                    $table->dropColumn($columnsToRemove);
                }
            });
        }
    }
}; 