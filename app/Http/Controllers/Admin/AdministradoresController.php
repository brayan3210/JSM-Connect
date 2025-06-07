<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdministradoresController extends Controller
{
    /**
     * Muestra la lista de administradores.
     */
    public function index(Request $request)
    {
        $query = Usuario::where('es_admin', true);
        
        // Filtrado por término de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%")
                  ->orWhere('numero_documento', 'like', "%{$buscar}%");
            });
        }
        
        // Filtrado por estado
        if ($request->filled('estado')) {
            if ($request->estado === 'activo') {
                $query->where('activo', true);
            } elseif ($request->estado === 'inactivo') {
                $query->where('activo', false);
            }
        }
        
        // Filtrado por género
        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }
        
        $administradores = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Estadísticas básicas
        $estadisticas = [
            'total' => Usuario::where('es_admin', true)->count(),
            'activos' => Usuario::where('es_admin', true)->where('activo', true)->count(),
            'inactivos' => Usuario::where('es_admin', true)->where('activo', false)->count(),
            'nuevos_mes' => Usuario::where('es_admin', true)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
        
        return view('admin.administradores.index', compact('administradores', 'estadisticas'));
    }
    
    /**
     * Muestra el formulario para crear un nuevo administrador.
     */
    public function create()
    {
        return view('admin.administradores.create');
    }
    
    /**
     * Almacena un nuevo administrador.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'tipo_documento' => ['required', 'string', 'max:50'],
            'numero_documento' => ['required', 'string', 'max:30', 'unique:usuarios,numero_documento'],
            'genero' => ['required', 'string', 'max:20'],
            'profesion' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],
            'telefono' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
            'activo' => ['boolean'],
        ]);
        
        $administrador = Usuario::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'genero' => $request->genero,
            'profesion' => $request->profesion,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'es_admin' => true,
            'activo' => $request->boolean('activo', true),
        ]);
        
        return redirect()->route('admin.administradores.index')
            ->with('success', 'Administrador creado exitosamente.');
    }
    
    /**
     * Muestra un administrador específico.
     */
    public function show(Usuario $administrador)
    {
        // Verificar que sea administrador
        if (!$administrador->es_admin) {
            abort(404);
        }
        
        return view('admin.administradores.show', compact('administrador'));
    }
    
    /**
     * Muestra el formulario para editar un administrador.
     */
    public function edit(Usuario $administrador)
    {
        // Verificar que sea administrador
        if (!$administrador->es_admin) {
            abort(404);
        }
        
        return view('admin.administradores.edit', compact('administrador'));
    }
    
    /**
     * Actualiza un administrador.
     */
    public function update(Request $request, Usuario $administrador)
    {
        // Verificar que sea administrador
        if (!$administrador->es_admin) {
            abort(404);
        }
        
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'tipo_documento' => ['required', 'string', 'max:50'],
            'numero_documento' => ['required', 'string', 'max:30', 'unique:usuarios,numero_documento,' . $administrador->id_usuario . ',id_usuario'],
            'genero' => ['required', 'string', 'max:20'],
            'profesion' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email,' . $administrador->id_usuario . ',id_usuario'],
            'telefono' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
            'activo' => ['boolean'],
        ]);
        
        $data = [
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'genero' => $request->genero,
            'profesion' => $request->profesion,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'activo' => $request->boolean('activo', true),
        ];
        
        // Solo actualizar password si se proporciona
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $administrador->update($data);
        
        return redirect()->route('admin.administradores.index')
            ->with('success', 'Administrador actualizado exitosamente.');
    }
    
    /**
     * Activa/desactiva un administrador.
     */
    public function toggleStatus(Usuario $administrador)
    {
        // Verificar que sea administrador
        if (!$administrador->es_admin) {
            abort(404);
        }
        
        // No permitir desactivar el propio usuario
        if ($administrador->id_usuario === auth()->user()->id_usuario) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta de administrador.');
        }
        
        $administrador->update([
            'activo' => !$administrador->activo
        ]);
        
        $status = $administrador->activo ? 'activado' : 'desactivado';
        
        return back()->with('success', "Administrador {$status} exitosamente.");
    }
    
    /**
     * Elimina un administrador (solo desactiva).
     */
    public function destroy(Usuario $administrador)
    {
        // Verificar que sea administrador
        if (!$administrador->es_admin) {
            abort(404);
        }
        
        // No permitir eliminar el propio usuario
        if ($administrador->id_usuario === auth()->user()->id_usuario) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }
        
        // En lugar de eliminar, desactivamos
        $administrador->update(['activo' => false]);
        
        return back()->with('success', 'Administrador desactivado exitosamente.');
    }
} 