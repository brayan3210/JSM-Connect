<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UsuariosController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index(Request $request)
    {
        $query = Usuario::query()->where('es_admin', false);
        
        // Filtrado
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $buscar = $request->buscar;
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%")
                  ->orWhere('numero_documento', 'like', "%{$buscar}%");
            });
        }
        
        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }
        
        if ($request->filled('profesion')) {
            $query->where('profesion', $request->profesion);
        }
        
        if ($request->filled('estado')) {
            $query->where('activo', $request->estado == 'activo');
        }
        
        $usuarios = $query->orderBy('id_usuario', 'desc')->paginate(10);
        
        // Estadísticas para la vista
        $estadisticas = [
            'total' => Usuario::where('es_admin', false)->count(),
            'activos' => Usuario::where('es_admin', false)->where('activo', true)->count(),
            'inactivos' => Usuario::where('es_admin', false)->where('activo', false)->count(),
            'admins' => Usuario::where('es_admin', true)->count(),
            'nuevos_mes' => Usuario::where('es_admin', false)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
        
        // Para filtros
        $generos = Usuario::selectRaw('genero, count(*) as total')
            ->where('es_admin', false)
            ->groupBy('genero')
            ->get();
            
        $profesiones = Usuario::selectRaw('profesion, count(*) as total')
            ->where('es_admin', false)
            ->groupBy('profesion')
            ->orderBy('profesion')
            ->get();
        
        return view('admin.usuarios.index', compact('usuarios', 'generos', 'profesiones', 'estadisticas'));
    }
    
    /**
     * Muestra la información de un usuario.
     */
    public function show(Usuario $usuario)
    {
        $servicios = $usuario->serviciosOfrecidos()->paginate(5, ['*'], 'servicios_page');
        $solicitudesRecibidas = $usuario->solicitudesRecibidas()->paginate(5, ['*'], 'solicitudes_recibidas_page');
        $solicitudesEnviadas = $usuario->solicitudesRealizadas()->paginate(5, ['*'], 'solicitudes_enviadas_page');
        
        return view('admin.usuarios.show', compact('usuario', 'servicios', 'solicitudesRecibidas', 'solicitudesEnviadas'));
    }
    
    /**
     * Muestra el formulario para editar un usuario.
     */
    public function edit(Usuario $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }
    
    /**
     * Actualiza la información de un usuario.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'tipo_documento' => ['required', 'string', 'max:50'],
            'numero_documento' => ['required', 'string', 'max:30', 'unique:usuarios,numero_documento,'.$usuario->id_usuario.',id_usuario'],
            'genero' => ['required', 'string', 'max:20'],
            'profesion' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email,'.$usuario->id_usuario.',id_usuario'],
            'telefono' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);
        
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->tipo_documento = $request->tipo_documento;
        $usuario->numero_documento = $request->numero_documento;
        $usuario->genero = $request->genero;
        $usuario->profesion = $request->profesion;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }
        
        $usuario->save();
        
        return redirect()->route('admin.usuarios.show', $usuario)
            ->with('success', 'Usuario actualizado correctamente.');
    }
    
    /**
     * Elimina un usuario.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
    
    /**
     * Activa la cuenta de un usuario.
     */
    public function activar(Usuario $usuario)
    {
        // Verificar que el usuario no esté ya activo
        if ($usuario->activo) {
            return redirect()->back()->with('info', 'El usuario ya está activo.');
        }
        
        $usuario->activo = true;
        $usuario->save();
        
        return redirect()->back()->with('success', "Usuario '{$usuario->nombre} {$usuario->apellidos}' activado correctamente. Ahora puede acceder a la plataforma.");
    }
    
    /**
     * Desactiva la cuenta de un usuario.
     */
    public function desactivar(Usuario $usuario)
    {
        // Verificar que el usuario no esté ya desactivado
        if (!$usuario->activo) {
            return redirect()->back()->with('info', 'El usuario ya está desactivado.');
        }
        
        // Verificar que no sea un administrador si es el único admin
        if ($usuario->es_admin) {
            $adminCount = Usuario::where('es_admin', true)->where('activo', true)->count();
            if ($adminCount <= 1) {
                return redirect()->back()->with('error', 'No se puede desactivar al único administrador activo del sistema.');
            }
        }
        
        $usuario->activo = false;
        $usuario->save();
        
        return redirect()->back()->with('success', "Usuario '{$usuario->nombre} {$usuario->apellidos}' desactivado correctamente. No podrá acceder a la plataforma hasta ser reactivado.");
    }
} 