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
        Schema::table('servicios', function (Blueprint $table) {
            // Cambiar precio por tipo de intercambio
            $table->dropColumn('precio');
            $table->string('tipo_intercambio')->default('Intercambio de tiempo por actividad');
            $table->text('descripcion_intercambio')->nullable()->comment('Descripción de lo que se pide a cambio');
            
            // Campos para el contador automático
            $table->integer('duracion_dias')->default(30)->comment('Duración en días antes de expirar');
            $table->datetime('fecha_expiracion')->nullable()->comment('Fecha en que expira el servicio');
            $table->boolean('expirado')->default(false)->comment('Si el servicio ha expirado automáticamente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            // Restaurar campos originales
            $table->decimal('precio', 10, 2)->default(0);
            $table->dropColumn([
                'tipo_intercambio',
                'descripcion_intercambio',
                'duracion_dias',
                'fecha_expiracion',
                'expirado'
            ]);
        });
    }
};
