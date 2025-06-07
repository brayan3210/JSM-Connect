<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Log;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    /**
     * Mostrar lista de usuarios para ver sus logs.
     */
    public function index(Request $request)
    {
        $query = Usuario::query();
        
        // Búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }
        
        // Filtro por tipo de usuario
        if ($request->filled('tipo_usuario')) {
            if ($request->tipo_usuario == 'admin') {
                $query->where('es_admin', true);
            } elseif ($request->tipo_usuario == 'usuario') {
                $query->where('es_admin', false);
            }
        }
        
        // Filtro por actividad
        if ($request->filled('con_logs')) {
            if ($request->con_logs == 'si') {
                $query->whereHas('logs');
            } elseif ($request->con_logs == 'no') {
                $query->whereDoesntHave('logs');
            }
        }
        
        // Cargar conteo de logs y último log
        $usuarios = $query->withCount('logs')
            ->with(['logs' => function($q) {
                $q->latest()->limit(1);
            }])
            ->orderBy('logs_count', 'desc')
            ->paginate(15);
            
        // Agregar último log a cada usuario
        foreach ($usuarios as $usuario) {
            $ultimo_log = Log::where('id_usuario', $usuario->id_usuario)
                ->latest()
                ->first();
            $usuario->ultimo_log = $ultimo_log ? $ultimo_log->created_at : null;
        }
        
        // Estadísticas generales
        $totalUsuarios = Usuario::count();
        $totalLogs = Log::count();
        $usuariosConLogs = Usuario::whereHas('logs')->count();
        $logsHoy = Log::whereDate('created_at', today())->count();
        
        return view('admin.logs.index', compact(
            'usuarios', 
            'totalUsuarios', 
            'totalLogs', 
            'usuariosConLogs', 
            'logsHoy'
        ));
    }

    /**
     * Mostrar logs de un usuario específico
     */
    public function show(Usuario $usuario, Request $request)
    {
        $query = Log::where('id_usuario', $usuario->id_usuario);

        // Filtros
        $tipo = $request->get('tipo');
        $fecha_desde = $request->get('fecha_desde');
        $fecha_hasta = $request->get('fecha_hasta');

        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        if ($fecha_desde) {
            $query->whereDate('created_at', '>=', $fecha_desde);
        }

        if ($fecha_hasta) {
            $query->whereDate('created_at', '<=', $fecha_hasta);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);

        // Estadísticas de los logs de este usuario
        $estadisticas = [
            'total' => Log::where('id_usuario', $usuario->id_usuario)->count(),
            'success' => Log::where('id_usuario', $usuario->id_usuario)->where('tipo', 'success')->count(),
            'info' => Log::where('id_usuario', $usuario->id_usuario)->where('tipo', 'info')->count(),
            'warning' => Log::where('id_usuario', $usuario->id_usuario)->where('tipo', 'warning')->count(),
            'error' => Log::where('id_usuario', $usuario->id_usuario)->where('tipo', 'error')->count(),
        ];

        return view('admin.logs.show', compact('usuario', 'logs', 'estadisticas', 'tipo', 'fecha_desde', 'fecha_hasta'));
    }

    /**
     * Exportar logs de un usuario en PDF
     */
    public function exportPdf(Usuario $usuario, Request $request)
    {
        $query = Log::where('id_usuario', $usuario->id_usuario);

        // Aplicar los mismos filtros que en show
        $tipo = $request->get('tipo');
        $fecha_desde = $request->get('fecha_desde');
        $fecha_hasta = $request->get('fecha_hasta');

        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        if ($fecha_desde) {
            $query->whereDate('created_at', '>=', $fecha_desde);
        }

        if ($fecha_hasta) {
            $query->whereDate('created_at', '<=', $fecha_hasta);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        // Estadísticas
        $estadisticas = [
            'total' => $logs->count(),
            'success' => $logs->where('tipo', 'success')->count(),
            'info' => $logs->where('tipo', 'info')->count(),
            'warning' => $logs->where('tipo', 'warning')->count(),
            'error' => $logs->where('tipo', 'error')->count(),
        ];

        $pdf = Pdf::loadView('admin.logs.pdf', compact('usuario', 'logs', 'estadisticas', 'tipo', 'fecha_desde', 'fecha_hasta'));

        $filename = 'logs_' . $usuario->nombre . '_' . $usuario->apellidos . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Limpiar logs antiguos (opcional, para mantenimiento)
     */
    public function limpiar(Request $request)
    {
        $request->validate([
            'meses' => 'required|integer|min:1|max:12'
        ]);

        $fecha_limite = now()->subMonths($request->meses);
        $logs_eliminados = Log::where('created_at', '<', $fecha_limite)->delete();

        // Registrar la acción de limpieza
        Log::create([
            'id_usuario' => Auth::id(),
            'accion' => 'Limpieza de logs',
            'descripcion' => "Se eliminaron {$logs_eliminados} logs anteriores a " . $fecha_limite->format('d/m/Y'),
            'tipo' => 'info',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'metodo_http' => request()->method(),
        ]);

        return redirect()->route('admin.logs.index')
            ->with('success', "Se eliminaron {$logs_eliminados} logs correctamente.");
    }
} 