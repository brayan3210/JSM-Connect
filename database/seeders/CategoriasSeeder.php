<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Programación',
                'descripcion' => 'Desarrollo de software, aplicaciones web y móviles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Diseño Gráfico',
                'descripcion' => 'Diseño de logos, banners, ilustraciones y material visual',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Marketing Digital',
                'descripcion' => 'Estrategias de marketing en redes sociales y plataformas digitales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Traducción',
                'descripcion' => 'Servicios de traducción de documentos e interpretación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Redacción',
                'descripcion' => 'Creación de contenido, artículos, blogs y material escrito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Fotografía',
                'descripcion' => 'Servicios de fotografía profesional para eventos y productos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Contabilidad',
                'descripcion' => 'Servicios contables, impuestos y finanzas personales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Asesoría Legal',
                'descripcion' => 'Consultoría y asesoría en temas legales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Educación',
                'descripcion' => 'Tutoría, clases particulares y formación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Salud',
                'descripcion' => 'Servicios relacionados con la salud y el bienestar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categorias')->insert($categorias);
    }
} 