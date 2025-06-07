<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Solicitud;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of all solicitudes.
     */
    public function index()
    {
        $usuario = Auth::user();
        
        $recibidas = $usuario->solicitudesRecibidas()
            ->with(['servicio', 'usuario_solicitante'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $enviadas = $usuario->solicitudesRealizadas()
            ->with(['servicio', 'usuario_proveedor'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('solicitudes.index', compact('recibidas', 'enviadas'));
    }

    /**
     * Display solicitudes enviadas.
     */
    public function enviadas()
    {
        $usuario = Auth::user();
        
        $enviadas = $usuario->solicitudesRealizadas()
            ->with(['servicio', 'usuario_proveedor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('solicitudes.enviadas', compact('enviadas'));
    }

    /**
     * Display solicitudes recibidas.
     */
    public function recibidas()
    {
        $usuario = Auth::user();
        
        $recibidas = $usuario->solicitudesRecibidas()
            ->with(['servicio', 'usuario_solicitante'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('solicitudes.recibidas', compact('recibidas'));
    }

    /**
     * Store a newly created solicitud.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_servicio' => ['required', 'exists:servicios,id_servicio'],
            'mensaje' => ['required', 'string'],
            'fecha_deseada' => ['nullable', 'date'],
        ]);
        
        $servicio = Servicio::findOrFail($request->id_servicio);
        
        // No permitir solicitudes a servicios propios
        if ($servicio->id_usuario === Auth::id()) {
            return back()->with('error', 'No puedes solicitar tus propios servicios.');
        }
        
        // No permitir solicitar servicios no disponibles
        if (!$servicio->disponible) {
            return back()->with('error', 'Este servicio no está disponible en este momento.');
        }
        
        // Verificar si ya existe una solicitud pendiente para este servicio
        $solicitudExistente = Solicitud::where('id_servicio', $servicio->id_servicio)
            ->where('id_usuario_solicitante', Auth::id())
            ->where('estado', 'pendiente')
            ->exists();
            
        if ($solicitudExistente) {
            return back()->with('error', 'Ya tienes una solicitud pendiente para este servicio.');
        }
        
        Solicitud::create([
            'id_servicio' => $servicio->id_servicio,
            'id_usuario_proveedor' => $servicio->id_usuario,
            'id_usuario_solicitante' => Auth::id(),
            'mensaje' => $request->mensaje,
            'fecha_deseada' => $request->fecha_deseada,
            'estado' => 'pendiente',
        ]);
        
        return redirect()->route('solicitudes.enviadas')
            ->with('success', 'Solicitud enviada correctamente. Espera la respuesta del proveedor.');
    }

    /**
     * Display the specified solicitud.
     */
    public function show(Solicitud $solicitud)
    {
        // Verificar que el usuario sea parte de la solicitud
        $usuarioActual = Auth::id();
        if ($solicitud->id_usuario_solicitante !== $usuarioActual && $solicitud->id_usuario_proveedor !== $usuarioActual) {
            abort(403, 'No tienes permisos para ver esta solicitud.');
        }
        
        return view('solicitudes.show', compact('solicitud'));
    }

    /**
     * Cambiar el estado de una solicitud (aceptar/rechazar/cancelar/completar).
     */
    public function cambiarEstado(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'estado' => ['required', 'string', 'in:aceptada,rechazada,cancelada,completada'],
            'comentario' => ['nullable', 'string'],
        ]);
        
        $usuarioActual = Auth::id();
        
        // Verificar permisos según la acción
        if ($request->estado === 'aceptada' || $request->estado === 'rechazada') {
            // Solo el proveedor puede aceptar o rechazar
            if ($solicitud->id_usuario_proveedor !== $usuarioActual) {
                abort(403, 'No tienes permisos para realizar esta acción.');
            }
        } elseif ($request->estado === 'cancelada') {
            // Solo el solicitante puede cancelar
            if ($solicitud->id_usuario_solicitante !== $usuarioActual) {
                abort(403, 'No tienes permisos para realizar esta acción.');
            }
        } elseif ($request->estado === 'completada') {
            // Cualquiera de las partes puede marcar como completada
            if ($solicitud->id_usuario_solicitante !== $usuarioActual && $solicitud->id_usuario_proveedor !== $usuarioActual) {
                abort(403, 'No tienes permisos para realizar esta acción.');
            }
        }
        
        // No permitir cambios de estado en solicitudes ya completadas, canceladas o rechazadas
        if (in_array($solicitud->estado, ['completada', 'cancelada', 'rechazada'])) {
            return back()->with('error', 'Esta solicitud ya ha sido ' . $solicitud->estado . ' y no se puede modificar.');
        }
        
        $solicitud->update([
            'estado' => $request->estado,
            'comentario_estado' => $request->comentario,
        ]);
        
        return back()->with('success', 'Estado de la solicitud actualizado correctamente.');
    }

    /**
     * Valorar un servicio completado.
     */
    public function valorar(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'puntuacion' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['nullable', 'string'],
        ]);
        
        // Solo el solicitante puede valorar
        if ($solicitud->id_usuario_solicitante !== Auth::id()) {
            abort(403, 'No tienes permisos para valorar esta solicitud.');
        }
        
        // Solo permitir valorar solicitudes completadas
        if ($solicitud->estado !== 'completada') {
            return back()->with('error', 'Solo puedes valorar servicios completados.');
        }
        
        // Verificar si ya se valoró
        if ($solicitud->puntuacion) {
            return back()->with('error', 'Ya has valorado esta solicitud.');
        }
        
        $solicitud->update([
            'puntuacion' => $request->puntuacion,
            'comentario_valoracion' => $request->comentario,
        ]);
        
        return back()->with('success', 'Gracias por tu valoración.');
    }
} 