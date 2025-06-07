<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MensajesController extends Controller
{
    /**
     * Display a listing of all messages.
     */
    public function index()
    {
        return $this->recibidos();
    }

    /**
     * Display sent messages.
     */
    public function enviados()
    {
        $usuario = Auth::user();
        
        $mensajes = $usuario->mensajesEnviados()
            ->with('destinatario')
            ->orderBy('fecha_envio', 'desc')
            ->paginate(15);
            
        return view('mensajes.enviados', compact('mensajes'));
    }

    /**
     * Get sent messages via AJAX for auto-refresh
     */
    public function enviadosAjax(Request $request)
    {
        $usuario = Auth::user();
        
        $page = $request->get('page', 1);
        
        $mensajes = $usuario->mensajesEnviados()
            ->with('destinatario')
            ->orderBy('fecha_envio', 'desc')
            ->paginate(15, ['*'], 'page', $page);
        
        $html = '';
        
        if ($mensajes->count() > 0) {
            $html .= '<div class="list-group" id="mensajes-list">';
            foreach ($mensajes as $mensaje) {
                $tiempoTranscurrido = $mensaje->fecha_envio->diffForHumans();
                $contenidoLimitado = \Str::limit($mensaje->contenido, 100);
                $iconoEstado = $mensaje->leido 
                    ? '<i class="fas fa-check-double text-success me-1"></i> Leído'
                    : '<i class="fas fa-check text-muted me-1"></i> Enviado';
                
                $html .= '<a href="' . route('mensajes.conversacion', $mensaje->destinatario) . '" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Para: ' . $mensaje->destinatario->nombre . ' ' . $mensaje->destinatario->apellidos . '</h6>
                        <small>' . $tiempoTranscurrido . '</small>
                    </div>
                    <p class="mb-1">' . $contenidoLimitado . '</p>
                    <small class="text-muted">' . $iconoEstado . '</small>
                </a>';
            }
            $html .= '</div>';
            
            // Agregar paginación después de la lista
            $html .= '<div class="d-flex justify-content-center mt-4" id="pagination-container">';
            $html .= $mensajes->links()->render();
            $html .= '</div>';
        } else {
            $html = '<div class="text-center py-4">
                <img src="' . asset('images/empty-sent.svg') . '" alt="No hay mensajes" class="img-fluid mb-3" style="max-height: 150px;">
                <h5>No has enviado mensajes</h5>
                <p class="text-muted">Cuando envíes un mensaje, aparecerá aquí.</p>
            </div>';
        }
        
        return response()->json([
            'html' => $html,
            'total' => $mensajes->total(),
            'current_page' => $mensajes->currentPage(),
            'last_page' => $mensajes->lastPage(),
            'has_messages' => $mensajes->count() > 0
        ]);
    }

    /**
     * Display received messages.
     */
    public function recibidos()
    {
        $usuario = Auth::user();
        
        $mensajes = $usuario->mensajesRecibidos()
            ->with('remitente')
            ->orderBy('fecha_envio', 'desc')
            ->paginate(15);
            
        return view('mensajes.recibidos', compact('mensajes'));
    }

    /**
     * Get received messages via AJAX for auto-refresh
     */
    public function recibidosAjax(Request $request)
    {
        $usuario = Auth::user();
        
        $page = $request->get('page', 1);
        
        $mensajes = $usuario->mensajesRecibidos()
            ->with('remitente')
            ->orderBy('fecha_envio', 'desc')
            ->paginate(15, ['*'], 'page', $page);
        
        $html = '';
        
        if ($mensajes->count() > 0) {
            $html .= '<div class="list-group" id="mensajes-list">';
            foreach ($mensajes as $mensaje) {
                $tiempoTranscurrido = $mensaje->fecha_envio->diffForHumans();
                $contenidoLimitado = \Str::limit($mensaje->contenido, 100);
                $claseNoLeido = !$mensaje->leido ? 'fw-bold' : '';
                $badgeNuevo = !$mensaje->leido ? '<span class="badge bg-primary">Nuevo</span>' : '';
                
                $html .= '<a href="' . route('mensajes.conversacion', $mensaje->remitente) . '" class="list-group-item list-group-item-action ' . $claseNoLeido . '">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">' . $mensaje->remitente->nombre . ' ' . $mensaje->remitente->apellidos . '</h6>
                        <small>' . $tiempoTranscurrido . '</small>
                    </div>
                    <p class="mb-1">' . $contenidoLimitado . '</p>
                    ' . $badgeNuevo . '
                </a>';
            }
            $html .= '</div>';
            
            // Agregar paginación después de la lista
            $html .= '<div class="d-flex justify-content-center mt-4" id="pagination-container">';
            $html .= $mensajes->links()->render();
            $html .= '</div>';
        } else {
            $html = '<div class="text-center py-4">
                <img src="' . asset('images/empty-inbox.svg') . '" alt="No hay mensajes" class="img-fluid mb-3" style="max-height: 150px;">
                <h5>No tienes mensajes recibidos</h5>
                <p class="text-muted">Cuando recibas mensajes, aparecerán aquí.</p>
            </div>';
        }
        
        return response()->json([
            'html' => $html,
            'total' => $mensajes->total(),
            'current_page' => $mensajes->currentPage(),
            'last_page' => $mensajes->lastPage(),
            'has_messages' => $mensajes->count() > 0,
            'unread_count' => $mensajes->where('leido', false)->count()
        ]);
    }

    /**
     * Show conversation with a specific user.
     */
    public function conversacion(Usuario $usuario)
    {
        $usuarioActual = Auth::user();
        
        // Get messages between current user and specified user
        $mensajes = Mensaje::where(function($query) use ($usuarioActual, $usuario) {
                $query->where('id_remitente', $usuarioActual->id_usuario)
                      ->where('id_destinatario', $usuario->id_usuario);
            })
            ->orWhere(function($query) use ($usuarioActual, $usuario) {
                $query->where('id_remitente', $usuario->id_usuario)
                      ->where('id_destinatario', $usuarioActual->id_usuario);
            })
            ->orderBy('fecha_envio', 'asc')
            ->get();
        
        // Mark unread messages as read
        $mensajesNoLeidos = $mensajes->where('id_destinatario', $usuarioActual->id_usuario)
                                    ->where('leido', false);
                                    
        if ($mensajesNoLeidos->count() > 0) {
            Mensaje::whereIn('id_mensaje', $mensajesNoLeidos->pluck('id_mensaje'))
                ->update(['leido' => true]);
        }
        
        // Get all users the current user has conversations with
        $contactos = $this->getContactos($usuarioActual);
        
        return view('mensajes.conversacion', compact('mensajes', 'usuario', 'contactos'));
    }

    /**
     * Get conversation messages via AJAX for auto-refresh
     */
    public function conversacionAjax(Usuario $usuario, Request $request)
    {
        $usuarioActual = Auth::user();
        
        // Get messages between current user and specified user
        $mensajes = Mensaje::where(function($query) use ($usuarioActual, $usuario) {
                $query->where('id_remitente', $usuarioActual->id_usuario)
                      ->where('id_destinatario', $usuario->id_usuario);
            })
            ->orWhere(function($query) use ($usuarioActual, $usuario) {
                $query->where('id_remitente', $usuario->id_usuario)
                      ->where('id_destinatario', $usuarioActual->id_usuario);
            })
            ->orderBy('fecha_envio', 'asc')
            ->get();
        
        // Mark unread messages as read
        $mensajesNoLeidos = $mensajes->where('id_destinatario', $usuarioActual->id_usuario)
                                    ->where('leido', false);
                                    
        if ($mensajesNoLeidos->count() > 0) {
            Mensaje::whereIn('id_mensaje', $mensajesNoLeidos->pluck('id_mensaje'))
                ->update(['leido' => true]);
        }
        
        $html = '';
        foreach ($mensajes as $mensaje) {
            $isOwn = $mensaje->id_remitente == $usuarioActual->id_usuario;
            $timeFormatted = $mensaje->fecha_envio->format('H:i');
            
            $html .= '<div class="mb-3 d-flex ' . ($isOwn ? 'justify-content-end' : 'justify-content-start') . '">
                <div class="chat-message ' . ($isOwn ? 'bg-primary text-white' : 'bg-light') . '" style="max-width: 75%; border-radius: 15px; padding: 10px 15px;">
                    <div>' . e($mensaje->contenido) . '</div>
                    <div class="text-end">
                        <small class="' . ($isOwn ? 'text-white-50' : 'text-muted') . '">
                            ' . $timeFormatted . '
                            ' . ($isOwn ? ($mensaje->leido ? '<i class="fas fa-check-double ms-1"></i>' : '<i class="fas fa-check ms-1"></i>') : '') . '
                        </small>
                    </div>
                </div>
            </div>';
        }
        
        return response()->json([
            'html' => $html,
            'messages_count' => $mensajes->count(),
            'unread_count' => $mensajesNoLeidos->count()
        ]);
    }

    /**
     * Store a new message via AJAX
     */
    public function storeAjax(Request $request)
    {
        $request->validate([
            'id_destinatario' => ['required', 'exists:usuarios,id_usuario'],
            'contenido' => ['required', 'string'],
        ]);
        
        $usuario = Auth::user();
        
        // Check if the destinatario is not the same as remitente
        if ($request->id_destinatario == $usuario->id_usuario) {
            return response()->json([
                'success' => false,
                'error' => 'No puedes enviarte mensajes a ti mismo.'
            ], 400);
        }
        
        $mensaje = Mensaje::create([
            'id_remitente' => $usuario->id_usuario,
            'id_destinatario' => $request->id_destinatario,
            'contenido' => $request->contenido,
            'fecha_envio' => now(),
            'leido' => false,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado correctamente.',
            'mensaje' => $mensaje->load('destinatario', 'remitente')
        ]);
    }

    /**
     * Store a new message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_destinatario' => ['required', 'exists:usuarios,id_usuario'],
            'contenido' => ['required', 'string'],
        ]);
        
        $usuario = Auth::user();
        
        // Check if the destinatario is not the same as remitente
        if ($request->id_destinatario == $usuario->id_usuario) {
            return back()->with('error', 'No puedes enviarte mensajes a ti mismo.');
        }
        
        Mensaje::create([
            'id_remitente' => $usuario->id_usuario,
            'id_destinatario' => $request->id_destinatario,
            'contenido' => $request->contenido,
            'fecha_envio' => now(),
            'leido' => false,
        ]);
        
        return redirect()->route('mensajes.conversacion', $request->id_destinatario)
            ->with('success', 'Mensaje enviado correctamente.');
    }

    /**
     * Mark a message as read.
     */
    public function marcarLeido(Mensaje $mensaje)
    {
        $usuario = Auth::user();
        
        // Check if the current user is the destinatario
        if ($mensaje->id_destinatario != $usuario->id_usuario) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        
        $mensaje->update(['leido' => true]);
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Get all contacts (users with whom the current user has exchanged messages).
     */
    private function getContactos($usuario)
    {
        $idContactos = Mensaje::where('id_remitente', $usuario->id_usuario)
            ->orWhere('id_destinatario', $usuario->id_usuario)
            ->get(['id_remitente', 'id_destinatario'])
            ->flatMap(function ($mensaje) use ($usuario) {
                return [
                    $mensaje->id_remitente == $usuario->id_usuario 
                        ? $mensaje->id_destinatario 
                        : $mensaje->id_remitente
                ];
            })
            ->unique()
            ->values();
            
        $contactos = Usuario::whereIn('id_usuario', $idContactos)->get();
        
        // Add unread count for each contact
        foreach ($contactos as $contacto) {
            $contacto->mensajes_no_leidos = Mensaje::where('id_remitente', $contacto->id_usuario)
                ->where('id_destinatario', $usuario->id_usuario)
                ->where('leido', false)
                ->count();
        }
        
        return $contactos;
    }
} 