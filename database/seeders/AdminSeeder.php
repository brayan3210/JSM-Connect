<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            'nombre' => 'Admin',
            'apellidos' => 'Sistema',
            'tipo_documento' => 'Cédula',
            'numero_documento' => '1000000000',
            'genero' => 'Otro',
            'profesion' => 'Administrador de Sistemas',
            'email' => 'admin@plataforma.com',
            'telefono' => '1234567890',
            'password' => Hash::make('password'),
            'es_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
} 