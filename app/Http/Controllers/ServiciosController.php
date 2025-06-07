<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ServiciosController extends Controller
{
    /**
     * Muestra la lista de servicios de intercambio disponibles con filtros.
     */
    public function index(Request $request)
    {
        // Ejecutar limpieza automática
        $this->cleanExpiredServices();
        
        $query = Servicio::with(['usuario', 'categoria']);
        
        // Filtrado por término de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%")
                  ->orWhere('descripcion_intercambio', 'like', "%{$buscar}%");
            });
        }
        
        // Filtrado por categoría
        if ($request->filled('categoria')) {
            $query->where('id_categoria', $request->categoria);
        }
        
        // Filtrado por tiempo restante
        if ($request->filled('tiempo_restante')) {
            switch ($request->tiempo_restante) {
                case 'urgente':
                    $query->whereNotNull('fecha_expiracion')
                          ->where('fecha_expiracion', '>', now())
                          ->where('fecha_expiracion', '<=', now()->addDays(3));
                    break;
                case 'pronto':
                    $query->whereNotNull('fecha_expiracion')
                          ->where('fecha_expiracion', '>', now())
                          ->where('fecha_expiracion', '<=', now()->addDays(7));
                    break;
                case 'tiempo':
                    $query->whereNotNull('fecha_expiracion')
                          ->where('fecha_expiracion', '>', now()->addDays(7));
                    break;
                case 'sin_limite':
                    $query->whereNull('fecha_expiracion');
                    break;
            }
        }
        
        // Filtrado por disponibilidad
        if ($request->filled('disponible')) {
            $query->where('disponible', true);
        }
        
        // Excluir expirados (por defecto está marcado)
        if ($request->filled('excluir_expirados') || !$request->has('excluir_expirados')) {
            $query->where('expirado', false)
                  ->where(function($q) {
                      $q->whereNull('fecha_expiracion')
                        ->orWhere('fecha_expiracion', '>', now());
                  });
        }
        
        $servicios = $query->orderBy('created_at', 'desc')->paginate(12);
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();
        
        return view('servicios.index', compact('servicios', 'categorias'));
    }
    
    /**
     * Muestra el formulario para crear un servicio de intercambio.
     */
    public function create()
    {
        $usuario = Auth::user();
        $categorias = $usuario->especialidades()
            ->where('disponible', true)
            ->get();
            
        if ($categorias->isEmpty()) {
            return redirect()->route('perfil.especialidades')
                ->with('info', 'Debes agregar especialidades antes de ofrecer servicios de intercambio.');
        }
        
        return view('servicios.create', compact('categorias'));
    }
    
    /**
     * Almacena un nuevo servicio de intercambio.
     */
    public function store(Request $request)
    {
        $usuario = Auth::user();
        
        $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'id_categoria' => ['required', 'exists:categorias,id_categoria'],
            'tipo_intercambio' => ['required', 'string', 'max:255'],
            'descripcion_intercambio' => ['required', 'string'],
            'duracion_dias' => ['required', 'integer', 'min:0', 'max:365'],
            'disponible' => ['boolean'],
        ]);
        
        // Verificar que el usuario tenga esta categoría como especialidad
        $tieneEspecialidad = $usuario->especialidades()
            ->wherePivot('id_categoria', $request->id_categoria)
            ->where('especialidades_usuarios.disponible', true)
            ->exists();
            
        if (!$tieneEspecialidad) {
            return back()->withErrors(['id_categoria' => 'No tienes esta categoría registrada como especialidad disponible.'])
                ->withInput();
        }
        
        $servicio = Servicio::create([
            'id_usuario' => $usuario->id_usuario,
            'id_categoria' => $request->id_categoria,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'tipo_intercambio' => $request->tipo_intercambio,
            'descripcion_intercambio' => $request->descripcion_intercambio,
            'duracion_dias' => $request->duracion_dias,
            'disponible' => $request->boolean('disponible', true),
        ]);
        
        return redirect()->route('servicios.show', $servicio)
            ->with('success', 'Servicio de intercambio creado correctamente.');
    }
    
    /**
     * Muestra un servicio específico.
     */
    public function show(Servicio $servicio)
    {
        // Obtener otros servicios del mismo proveedor (solo activos)
        $otrosServicios = Servicio::where('id_usuario', $servicio->id_usuario)
            ->where('id_servicio', '!=', $servicio->id_servicio)
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('servicios.show', compact('servicio', 'otrosServicios'));
    }
    
    /**
     * Muestra el formulario para editar un servicio.
     */
    public function edit(Servicio $servicio)
    {
        $this->autorizarServicio($servicio);
        
        $usuario = Auth::user();
        $categorias = $usuario->especialidades()
            ->where('disponible', true)
            ->get();
            
        return view('servicios.edit', compact('servicio', 'categorias'));
    }
    
    /**
     * Actualiza un servicio de intercambio.
     */
    public function update(Request $request, Servicio $servicio)
    {
        $this->autorizarServicio($servicio);
        
        $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'id_categoria' => ['required', 'exists:categorias,id_categoria'],
            'tipo_intercambio' => ['required', 'string', 'max:255'],
            'descripcion_intercambio' => ['required', 'string'],
            'duracion_dias' => ['required', 'integer', 'min:0', 'max:365'],
            'disponible' => ['boolean'],
        ]);
        
        // Verificar que el usuario tenga esta categoría como especialidad
        $usuario = Auth::user();
        $tieneEspecialidad = $usuario->especialidades()
            ->wherePivot('id_categoria', $request->id_categoria)
            ->where('especialidades_usuarios.disponible', true)
            ->exists();
            
        if (!$tieneEspecialidad) {
            return back()->withErrors(['id_categoria' => 'No tienes esta categoría registrada como especialidad disponible.'])
                ->withInput();
        }
        
        $servicio->update([
            'id_categoria' => $request->id_categoria,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'tipo_intercambio' => $request->tipo_intercambio,
            'descripcion_intercambio' => $request->descripcion_intercambio,
            'duracion_dias' => $request->duracion_dias,
            'disponible' => $request->boolean('disponible', true),
        ]);
        
        return redirect()->route('servicios.show', $servicio)
            ->with('success', 'Servicio de intercambio actualizado correctamente.');
    }
    
    /**
     * Elimina un servicio.
     */
    public function destroy(Servicio $servicio)
    {
        $this->autorizarServicio($servicio);
        
        // Verificar si tiene solicitudes
        $tieneSolicitudes = $servicio->solicitudes()->exists();
        
        if ($tieneSolicitudes) {
            return back()->with('error', 'No se puede eliminar este servicio porque tiene solicitudes asociadas. Considere marcarlo como no disponible.');
        }
        
        $servicio->delete();
        
        return redirect()->route('servicios.index')
            ->with('success', 'Servicio de intercambio eliminado correctamente.');
    }
    
    /**
     * Muestra servicios por categoría.
     */
    public function porCategoria(Categoria $categoria)
    {
        $servicios = Servicio::where('id_categoria', $categoria->id_categoria)
            ->active()
            ->with(['usuario', 'categoria'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        return view('servicios.categoria', compact('servicios', 'categoria'));
    }
    
    /**
     * Busca servicios de intercambio según filtros.
     */
    public function buscar(Request $request)
    {
        $query = Servicio::active();
        
        // Filtrado por término de búsqueda
        if ($request->filled('query')) {
            $buscar = $request->query;
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%")
                  ->orWhere('descripcion_intercambio', 'like', "%{$buscar}%");
            });
        }
        
        // Filtrado por categoría
        if ($request->filled('categoria')) {
            $query->where('id_categoria', $request->categoria);
        }
        
        $servicios = $query->with(['usuario', 'categoria'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();
        
        return view('servicios.buscar', compact('servicios', 'categorias'));
    }
    
    /**
     * Ver perfil de un usuario/profesional.
     */
    public function verUsuario(Usuario $usuario)
    {
        // No permitir ver perfiles de administradores o inactivos
        if ($usuario->es_admin || !$usuario->activo) {
            abort(404);
        }
        
        $servicios = $usuario->serviciosOfrecidos()
            ->active()
            ->with('categoria')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
            
        $especialidades = $usuario->especialidades()
            ->where('especialidades_usuarios.disponible', true)
            ->get();
            
        return view('servicios.verUsuario', compact('usuario', 'servicios', 'especialidades'));
    }
    
    /**
     * Muestra todos los servicios de intercambio disponibles.
     */
    public function todos()
    {
        $servicios = Servicio::active()
            ->with(['usuario', 'categoria'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();
        
        return view('servicios.todos', compact('servicios', 'categorias'));
    }
    
    /**
     * Autoriza el acceso a un servicio para operaciones de edición/eliminación.
     */
    protected function autorizarServicio(Servicio $servicio)
    {
        if ($servicio->id_usuario !== Auth::user()->id_usuario) {
            abort(403, 'No tienes permisos para modificar este servicio de intercambio.');
        }
    }
    
    /**
     * Limpia automáticamente los servicios expirados.
     */
    private function cleanExpiredServices()
    {
        try {
            $serviciosExpirados = Servicio::where('expirado', false)
                ->where('disponible', true)
                ->whereNotNull('fecha_expiracion')
                ->where('fecha_expiracion', '<=', now())
                ->get();
            
            foreach ($serviciosExpirados as $servicio) {
                $servicio->markAsExpired();
            }
        } catch (\Exception $e) {
            \Log::error('Error limpiando servicios expirados: ' . $e->getMessage());
        }
    }
} 