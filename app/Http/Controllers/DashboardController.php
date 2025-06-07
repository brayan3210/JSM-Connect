<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Servicio;
use App\Models\SolicitudServicio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard del usuario normal.
     */
    public function index()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
        
        // Ejecutar limpieza automática de servicios expirados
        $this->cleanExpiredServices();
        
        // Obtener categorías para filtrado
        $categorias = Categoria::where('activo', true)->get();
        
        // Servicios de intercambio ofrecidos por el usuario (incluyendo expirados para mostrar estado)
        $serviciosOfrecidos = $usuario->serviciosOfrecidos()
            ->with('categoria')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Servicios de intercambio recientes disponibles de otros usuarios (solo activos)
        $serviciosRecientes = Servicio::active()
            ->where('id_usuario', '!=', $usuario->id_usuario)
            ->with(['usuario', 'categoria'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        // Solicitudes recibidas pendientes
        $solicitudesRecibidas = $usuario->solicitudesRecibidas()
            ->where('estado', 'pendiente')
            ->with(['servicio', 'usuario_solicitante'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Solicitudes enviadas pendientes
        $solicitudesEnviadas = $usuario->solicitudesRealizadas()
            ->where('estado', 'pendiente')
            ->with(['servicio', 'usuario_proveedor'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Obtener estadísticas del usuario
        $estadisticas = [
            'servicios_activos' => $usuario->serviciosOfrecidos()->active()->count(),
            'solicitudes_pendientes' => $usuario->solicitudesRecibidas()->where('estado', 'pendiente')->count(),
            'solicitudes_enviadas_pendientes' => $usuario->solicitudesRealizadas()->where('estado', 'pendiente')->count(),
            'especialidades_count' => $usuario->especialidades()->count(),
        ];
        
        // Mensajes no leídos
        $mensajesNoLeidos = $usuario->mensajesRecibidos()->where('leido', false)->count();
        
        return view('dashboard.index', compact(
            'usuario', 
            'categorias',
            'serviciosOfrecidos',
            'serviciosRecientes',
            'solicitudesRecibidas',
            'solicitudesEnviadas',
            'estadisticas',
            'mensajesNoLeidos'
        ));
    }
    
    /**
     * Limpia automáticamente los servicios expirados
     */
    private function cleanExpiredServices()
    {
        try {
            // Buscar servicios que han expirado pero aún no están marcados como tal
            $serviciosExpirados = Servicio::where('expirado', false)
                ->where('disponible', true)
                ->whereNotNull('fecha_expiracion')
                ->where('fecha_expiracion', '<=', now())
                ->get();
            
            foreach ($serviciosExpirados as $servicio) {
                $servicio->markAsExpired();
            }
        } catch (\Exception $e) {
            // Silenciosamente fallar para no interrumpir el dashboard
            \Log::error('Error limpiando servicios expirados: ' . $e->getMessage());
        }
    }
} 