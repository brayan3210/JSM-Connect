<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Estadistica;
use App\Models\Servicio;
use App\Models\SolicitudServicio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticasController extends Controller
{
    /**
     * Muestra la página principal de estadísticas.
     */
    public function index()
    {
        // Estadísticas generales
        $estadisticas = [
            'total_usuarios' => Usuario::where('es_admin', false)->count(),
            'total_servicios' => Servicio::count(),
            'total_solicitudes' => SolicitudServicio::count(),
            'total_categorias' => Categoria::count(),
            'total_logs' => \App\Models\Log::count(),
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
            ->limit(10)
            ->get();

        // Usuarios por profesión (para la tabla)
        $usuariosPorProfesion = Usuario::where('es_admin', false)
            ->selectRaw('profesion, count(*) as total')
            ->groupBy('profesion')
            ->orderByRaw('count(*) DESC')
            ->limit(15)
            ->get();

        // Top categorías utilizadas
        $topCategorias = Servicio::selectRaw('categorias.nombre, COUNT(*) as total')
            ->join('categorias', 'servicios.id_categoria', '=', 'categorias.id_categoria')
            ->groupBy('categorias.nombre')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)
            ->get();

        // Estados de solicitudes
        $estadosSolicitudes = SolicitudServicio::selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->get();

        // Usuarios recientes (filtrar los que tienen created_at null)
        $usuariosRecientes = Usuario::whereNotNull('created_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.estadisticas.index', compact(
            'estadisticas',
            'usuariosPorGenero',
            'topProfesiones',
            'usuariosPorProfesion',
            'topCategorias',
            'estadosSolicitudes',
            'usuariosRecientes'
        ));
    }

    /**
     * Estadísticas de usuarios.
     */
    public function usuarios()
    {
        // Total usuarios
        $totalUsuarios = Usuario::where('es_admin', false)->count();
        
        // Estadísticas básicas
        $estadisticas = [
            'total' => $totalUsuarios,
            'activos' => Usuario::where('es_admin', false)->where('activo', true)->count(),
            'inactivos' => Usuario::where('es_admin', false)->where('activo', false)->count(),
            'admins' => Usuario::where('es_admin', true)->count(),
            'nuevos_mes' => Usuario::where('es_admin', false)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
        
        // Usuarios por fecha de registro (últimos 12 meses)
        $usuariosPorMes = Usuario::where('es_admin', false)
            ->selectRaw('YEAR(created_at) year, MONTH(created_at) month, COUNT(*) total')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Formatear los datos para gráfico
        $meses = [];
        $totalesPorMes = [];
        $registrosPorMes = collect();
        
        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $year = $fecha->year;
            $month = $fecha->month;
            
            $meses[] = $fecha->format('M Y');
            
            $encontrado = false;
            foreach ($usuariosPorMes as $dato) {
                if ($dato->year == $year && $dato->month == $month) {
                    $totalesPorMes[] = $dato->total;
                    $registrosPorMes->push((object)[
                        'mes' => $fecha->format('M Y'),
                        'total' => $dato->total
                    ]);
                    $encontrado = true;
                    break;
                }
            }
            
            if (!$encontrado) {
                $totalesPorMes[] = 0;
                $registrosPorMes->push((object)[
                    'mes' => $fecha->format('M Y'),
                    'total' => 0
                ]);
            }
        }
        
        // Usuarios activos vs inactivos
        $usuariosActivos = Usuario::where('es_admin', false)->where('activo', true)->count();
        $usuariosInactivos = $totalUsuarios - $usuariosActivos;
        
        // Usuarios recientes (filtrar los que tienen created_at null)
        $usuariosRecientes = Usuario::where('es_admin', false)
            ->whereNotNull('created_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Top profesiones
        $topProfesiones = Usuario::where('es_admin', false)
            ->selectRaw('profesion, count(*) as total')
            ->groupBy('profesion')
            ->orderByRaw('count(*) DESC')
            ->limit(10)
            ->get();
        
        // Usuarios por género
        $usuariosPorGenero = Usuario::where('es_admin', false)
            ->selectRaw('genero, count(*) as total')
            ->groupBy('genero')
            ->get();
        
        // Formatear registros por mes para la vista
        $registrosPorMes = collect();
        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $year = $fecha->year;
            $month = $fecha->month;
            
            $encontrado = false;
            foreach ($usuariosPorMes as $dato) {
                if ($dato->year == $year && $dato->month == $month) {
                    $registrosPorMes->push((object)[
                        'mes' => $fecha->format('M Y'),
                        'total' => $dato->total
                    ]);
                    $encontrado = true;
                    break;
                }
            }
            
            if (!$encontrado) {
                $registrosPorMes->push((object)[
                    'mes' => $fecha->format('M Y'),
                    'total' => 0
                ]);
            }
        }
        
        return view('admin.estadisticas.usuarios', compact(
            'totalUsuarios',
            'estadisticas',
            'meses',
            'totalesPorMes',
            'usuariosActivos',
            'usuariosInactivos',
            'usuariosRecientes',
            'topProfesiones',
            'registrosPorMes',
            'usuariosPorGenero'
        ));
    }

    /**
     * Estadísticas por género.
     */
    public function genero()
    {
        // Total usuarios para cálculos
        $totalUsuarios = Usuario::where('es_admin', false)->count();
        
        // Usuarios por género
        $generos = Usuario::where('es_admin', false)
            ->selectRaw('genero, count(*) as total')
            ->groupBy('genero')
            ->get();
            
        // Usuarios por género (mismo data con diferente variable)
        $usuariosPorGenero = $generos;
        
        // Calcular total para porcentajes
        $total = $usuariosPorGenero->sum('total');
        if ($total == 0) {
            $total = 1; // Evitar división por cero
        }
            
        // Servicios por género
        $serviciosPorGenero = Servicio::selectRaw('usuarios.genero, COUNT(*) as total')
            ->join('usuarios', 'servicios.id_usuario', '=', 'usuarios.id_usuario')
            ->where('usuarios.es_admin', false)
            ->groupBy('usuarios.genero')
            ->get();
            
        // Solicitudes por género (solicitante)
        $solicitudesPorGeneroSolicitante = SolicitudServicio::selectRaw('usuarios.genero, COUNT(*) as total')
            ->join('usuarios', 'solicitudes_servicios.id_usuario_solicitante', '=', 'usuarios.id_usuario')
            ->groupBy('usuarios.genero')
            ->get();
            
        // Solicitudes por género (proveedor)
        $solicitudesPorGeneroProveedor = SolicitudServicio::selectRaw('usuarios.genero, COUNT(*) as total')
            ->join('usuarios', 'solicitudes_servicios.id_usuario_proveedor', '=', 'usuarios.id_usuario')
            ->groupBy('usuarios.genero')
            ->get();
        
        return view('admin.estadisticas.genero', compact(
            'generos',
            'usuariosPorGenero',
            'total',
            'totalUsuarios',
            'serviciosPorGenero',
            'solicitudesPorGeneroSolicitante',
            'solicitudesPorGeneroProveedor'
        ));
    }

    /**
     * Estadísticas por profesión.
     */
    public function profesiones()
    {
        // Total profesiones distintas
        $totalProfesiones = Usuario::where('es_admin', false)
            ->distinct('profesion')
            ->count('profesion');
            
        // Top profesiones
        $topProfesiones = Usuario::where('es_admin', false)
            ->selectRaw('profesion, count(*) as total')
            ->groupBy('profesion')
            ->orderByRaw('count(*) DESC')
            ->limit(15)
            ->get();
            
        // Servicios por profesión (top 10)
        $serviciosPorProfesion = Servicio::selectRaw('usuarios.profesion, COUNT(*) as total')
            ->join('usuarios', 'servicios.id_usuario', '=', 'usuarios.id_usuario')
            ->groupBy('usuarios.profesion')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)
            ->get();
        
        // Usuarios sin profesión especificada
        $usuariosSinProfesion = Usuario::where('es_admin', false)
            ->where(function($query) {
                $query->whereNull('profesion')
                      ->orWhere('profesion', '');
            })
            ->count();
        
        // Todas las profesiones para la tabla detallada
        $profesiones = Usuario::where('es_admin', false)
            ->selectRaw('
                profesion, 
                count(*) as total,
                SUM(CASE WHEN es_admin = 1 THEN 1 ELSE 0 END) as admins,
                SUM(CASE WHEN es_admin = 0 THEN 1 ELSE 0 END) as usuarios,
                SUM(CASE WHEN activo = 1 THEN 1 ELSE 0 END) as activos
            ')
            ->groupBy('profesion')
            ->orderByRaw('count(*) DESC')
            ->get();
        
        // Total usuarios para porcentajes
        $totalUsuarios = Usuario::where('es_admin', false)->count();
        
        return view('admin.estadisticas.profesiones', compact(
            'totalProfesiones',
            'topProfesiones',
            'serviciosPorProfesion',
            'usuariosSinProfesion',
            'profesiones',
            'totalUsuarios'
        ));
    }

    /**
     * Estadísticas por categoría.
     */
    public function categorias()
    {
        // Total categorías
        $totalCategorias = Categoria::count();
        
        // Total servicios para la vista
        $totalServicios = Servicio::count();
        
        // Categorías y totales
        $categorias = Categoria::withCount(['servicios', 'usuariosInteresados', 'usuariosEspecialistas'])
            ->get();
            
        // Servicios por categoría
        $serviciosPorCategoria = Servicio::selectRaw('categorias.nombre, COUNT(*) as total')
            ->join('categorias', 'servicios.id_categoria', '=', 'categorias.id_categoria')
            ->groupBy('categorias.nombre')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
            
        // Solicitudes por categoría
        $solicitudesPorCategoria = SolicitudServicio::selectRaw('categorias.nombre, COUNT(*) as total')
            ->join('servicios', 'solicitudes_servicios.id_servicio', '=', 'servicios.id_servicio')
            ->join('categorias', 'servicios.id_categoria', '=', 'categorias.id_categoria')
            ->groupBy('categorias.nombre')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
        
        return view('admin.estadisticas.categorias', compact(
            'totalCategorias',
            'categorias',
            'serviciosPorCategoria',
            'solicitudesPorCategoria',
            'totalServicios'
        ));
    }

    /**
     * Estadísticas de servicios.
     */
    public function servicios()
    {
        // Total servicios
        $totalServicios = Servicio::count();
        
        // Estadísticas básicas
        $estadisticas = [
            'total' => $totalServicios,
            'activos' => Servicio::where('disponible', true)->count(),
            'inactivos' => Servicio::where('disponible', false)->count(),
            'expirados' => Servicio::where('expirado', true)->count(),
            'este_mes' => Servicio::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
        
        // Servicios por mes (últimos 12 meses)
        $serviciosPorMes = Servicio::selectRaw('YEAR(created_at) year, MONTH(created_at) month, COUNT(*) total')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Formatear los datos para gráfico
        $meses = [];
        $totalesPorMes = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $year = $fecha->year;
            $month = $fecha->month;
            
            $meses[] = $fecha->format('M Y');
            
            $encontrado = false;
            foreach ($serviciosPorMes as $dato) {
                if ($dato->year == $year && $dato->month == $month) {
                    $totalesPorMes[] = $dato->total;
                    $encontrado = true;
                    break;
                }
            }
            
            if (!$encontrado) {
                $totalesPorMes[] = 0;
            }
        }
        
        // Servicios activos vs inactivos
        $serviciosActivos = Servicio::where('disponible', true)->count();
        $serviciosInactivos = $totalServicios - $serviciosActivos;
        
        // Top servicios solicitados
        $topServicios = SolicitudServicio::selectRaw('servicios.titulo, COUNT(*) as total')
            ->join('servicios', 'solicitudes_servicios.id_servicio', '=', 'servicios.id_servicio')
            ->groupBy('servicios.titulo')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)
            ->get();
        
        // Servicios más solicitados con información completa
        $serviciosMasSolicitados = Servicio::withCount('solicitudes')
            ->with(['categoria', 'usuario'])
            ->orderBy('solicitudes_count', 'desc')
            ->limit(10)
            ->get();
        
        // Tipos de intercambio
        $tiposIntercambio = Servicio::selectRaw('tipo_intercambio, COUNT(*) as cantidad')
            ->whereNotNull('tipo_intercambio')
            ->groupBy('tipo_intercambio')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
        
        // Duración de servicios
        $duracionServicios = collect([
            (object)['rango' => '1 día', 'cantidad' => Servicio::where('duracion_dias', 1)->count()],
            (object)['rango' => '3 días', 'cantidad' => Servicio::where('duracion_dias', 3)->count()],
            (object)['rango' => '1 semana (7 días)', 'cantidad' => Servicio::where('duracion_dias', 7)->count()],
            (object)['rango' => '2 semanas (14 días)', 'cantidad' => Servicio::where('duracion_dias', 14)->count()],
            (object)['rango' => '1 mes (30 días)', 'cantidad' => Servicio::where('duracion_dias', 30)->count()],
            (object)['rango' => '2+ meses (60+ días)', 'cantidad' => Servicio::where('duracion_dias', '>=', 60)->count()],
            (object)['rango' => 'Sin límite de tiempo', 'cantidad' => Servicio::where('duracion_dias', 0)->orWhereNull('duracion_dias')->count()],
        ]);
        
        // Servicios por categoría
        $serviciosPorCategoria = Servicio::selectRaw('categorias.nombre, COUNT(*) as servicios_count')
            ->join('categorias', 'servicios.id_categoria', '=', 'categorias.id_categoria')
            ->groupBy('categorias.nombre')
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        return view('admin.estadisticas.servicios', compact(
            'totalServicios',
            'estadisticas',
            'meses',
            'totalesPorMes',
            'serviciosActivos',
            'serviciosInactivos',
            'topServicios',
            'serviciosMasSolicitados',
            'tiposIntercambio',
            'duracionServicios',
            'serviciosPorCategoria'
        ));
    }
} 