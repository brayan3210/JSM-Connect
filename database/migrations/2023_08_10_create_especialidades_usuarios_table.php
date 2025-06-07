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
        Schema::table('especialidades_usuarios', function (Blueprint $table) {
            if (!Schema::hasColumn('especialidades_usuarios', 'experiencia_anios')) {
                $table->integer('experiencia_anios')->default(0);
            }
            if (!Schema::hasColumn('especialidades_usuarios', 'tarifa_hora')) {
                $table->decimal('tarifa_hora', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('especialidades_usuarios', 'descripcion')) {
                $table->text('descripcion')->nullable();
            }
            if (!Schema::hasColumn('especialidades_usuarios', 'disponible')) {
                $table->boolean('disponible')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('especialidades_usuarios', function (Blueprint $table) {
            $table->dropColumn(['experiencia_anios', 'tarifa_hora', 'descripcion', 'disponible']);
        });
    }
}; 