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
        if (!Schema::hasTable('mensajes')) {
            Schema::create('mensajes', function (Blueprint $table) {
                $table->id('id_mensaje');
                $table->unsignedBigInteger('id_remitente');
                $table->unsignedBigInteger('id_destinatario');
                $table->text('contenido');
                $table->dateTime('fecha_envio')->default(now());
                $table->boolean('leido')->default(false);
                $table->timestamps();
    
                $table->foreign('id_remitente')->references('id_usuario')->on('usuarios');
                $table->foreign('id_destinatario')->references('id_usuario')->on('usuarios');
            });
        } else {
            Schema::table('mensajes', function (Blueprint $table) {
                if (!Schema::hasColumn('mensajes', 'created_at')) {
                    $table->timestamps();
                }
                
                if (!Schema::hasColumn('mensajes', 'fecha_envio')) {
                    $table->dateTime('fecha_envio')->default(now());
                }
                
                if (!Schema::hasColumn('mensajes', 'leido')) {
                    $table->boolean('leido')->default(false);
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
        if (Schema::hasTable('mensajes')) {
            Schema::table('mensajes', function (Blueprint $table) {
                if (Schema::hasColumn('mensajes', 'created_at')) {
                    $table->dropColumn(['created_at', 'updated_at']);
                }
            });
        }
    }
}; 