<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    /**
     * Muestra la lista de categorías.
     */
    public function index(Request $request)
    {
        $query = Categoria::query();
        
        // Filtrado
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $buscar = $request->buscar;
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }
        
        if ($request->has('activo')) {
            $query->where('activo', $request->boolean('activo'));
        }
        
        $categorias = $query->withCount(['servicios', 'usuariosInteresados', 'usuariosEspecialistas'])
            ->orderBy('nombre')
            ->paginate(10);
        
        // Estadísticas para la vista
        $estadisticas = [
            'total' => Categoria::count(),
            'activas' => Categoria::where('activo', true)->count(),
            'inactivas' => Categoria::where('activo', false)->count(),
            'con_usuarios' => Categoria::whereHas('servicios')->orWhereHas('usuariosInteresados')->orWhereHas('usuariosEspecialistas')->count(),
        ];
        
        return view('admin.categorias.index', compact('categorias', 'estadisticas'));
    }
    
    /**
     * Muestra el formulario para crear una categoría.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }
    
    /**
     * Almacena una nueva categoría.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:categorias'],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['boolean'],
        ]);
        
        $categoria = Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->boolean('activo', true),
        ]);
        
        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }
    
    /**
     * Muestra el formulario para editar una categoría.
     */
    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }
    
    /**
     * Actualiza la categoría.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:categorias,nombre,'.$categoria->id_categoria.',id_categoria'],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['boolean'],
        ]);
        
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->activo = $request->boolean('activo', true);
        $categoria->save();
        
        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }
    
    /**
     * Desactiva una categoría.
     */
    public function desactivar(Categoria $categoria)
    {
        $categoria->activo = false;
        $categoria->save();
        
        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría desactivada correctamente.');
    }
    
    /**
     * Activa una categoría.
     */
    public function activar(Categoria $categoria)
    {
        $categoria->activo = true;
        $categoria->save();
        
        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría activada correctamente.');
    }
    
    /**
     * Elimina una categoría.
     */
    public function destroy(Categoria $categoria)
    {
        // Validar si la categoría está en uso
        $serviciosCount = $categoria->servicios()->count();
        $interesadosCount = $categoria->usuariosInteresados()->count();
        $especialistasCount = $categoria->usuariosEspecialistas()->count();
        
        if ($serviciosCount > 0 || $interesadosCount > 0 || $especialistasCount > 0) {
            return redirect()->route('admin.categorias.index')
                ->with('error', 'No se puede eliminar la categoría porque está siendo utilizada. Considere desactivarla en su lugar.');
        }
        
        $categoria->delete();
        
        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
} 