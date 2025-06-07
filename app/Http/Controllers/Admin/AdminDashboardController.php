<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Estadistica;
use App\Models\Servicio;
use App\Models\SolicitudServicio;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Muestra el dashboard del administrador.
     */
    public function index()
    {
        // Estadísticas generales
        $estadisticas = [
            'total_usuarios' => Usuario::where('es_admin', false)->count(),
            'total_servicios' => Servicio::count(),
            'total_solicitudes' => SolicitudServicio::count(),
            'total_categorias' => Categoria::count(),
        ];
        
        // Usuarios por género
        $usuariosPorGenero = Usuario::where('es_admin', false)
            ->selectRaw('genero, count(*) as total')
            ->groupBy('genero')
            ->get();
        
        // Top profesiones
        $topProfesiones = Usuario::where('es_admin', false)
            ->selectRaw('profesion, count(*) as total')
            ->groupBy('profesion')
            ->orderByRaw('count(*) DESC')
            ->limit(5)
            ->get();
        
        // Top categorías utilizadas
        $topCategorias = Servicio::selectRaw('categorias.nombre, COUNT(*) as total')
            ->join('categorias', 'servicios.id_categoria', '=', 'categorias.id_categoria')
            ->groupBy('categorias.nombre')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->get();
        
        // Últimos usuarios registrados
        $ultimosUsuarios = Usuario::where('es_admin', false)
            ->orderBy('id_usuario', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'estadisticas',
            'usuariosPorGenero',
            'topProfesiones',
            'topCategorias',
            'ultimosUsuarios'
        ));
    }
} 