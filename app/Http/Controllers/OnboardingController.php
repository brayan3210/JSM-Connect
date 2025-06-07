<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\PreferenciaUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    /**
     * Muestra el formulario para añadir preferencias.
     */
    public function showPreferences()
    {
        return view('onboarding.preferences');
    }

    /**
     * Almacena las preferencias del usuario.
     */
    public function storePreferences(Request $request)
    {
        $request->validate([
            'hobbies' => ['required', 'array', 'min:1'],
            'hobbies.*' => ['required', 'string', 'max:100'],
            'descripciones' => ['required', 'array', 'min:1', 'size:' . count($request->hobbies)],
            'descripciones.*' => ['required', 'string'],
        ]);

        $usuario = Auth::user();

        // Eliminar preferencias existentes
        $usuario->preferencias()->delete();

        // Crear nuevas preferencias
        foreach ($request->hobbies as $i => $hobby) {
            PreferenciaUsuario::create([
                'id_usuario' => $usuario->id_usuario,
                'hobby' => $hobby,
                'descripcion' => $request->descripciones[$i],
            ]);
        }

        return redirect()->route('onboarding.interests');
    }

    /**
     * Muestra el formulario para seleccionar categorías de interés.
     */
    public function showInterests()
    {
        $categorias = Categoria::where('activo', true)->get();
        return view('onboarding.interests', compact('categorias'));
    }

    /**
     * Almacena las categorías de interés seleccionadas.
     */
    public function storeInterests(Request $request)
    {
        $request->validate([
            'categorias' => ['required', 'array', 'min:1'],
            'categorias.*' => ['required', 'exists:categorias,id_categoria'],
        ]);

        $usuario = Auth::user();

        // Sincronizar las categorías de interés
        $usuario->intereses()->sync($request->categorias);

        return redirect()->route('onboarding.specialties');
    }

    /**
     * Muestra el formulario para añadir especialidades.
     */
    public function showSpecialties()
    {
        $categorias = Categoria::where('activo', true)->get();
        $usuarioCategorias = Auth::user()->especialidades->pluck('id_categoria')->toArray();
        
        return view('onboarding.specialties', compact('categorias', 'usuarioCategorias'));
    }

    /**
     * Almacena las especialidades del usuario.
     */
    public function storeSpecialties(Request $request)
    {
        $request->validate([
            'categorias' => ['required', 'array', 'min:1'],
            'categorias.*' => ['required', 'exists:categorias,id_categoria'],
            'descripciones' => ['required', 'array', 'size:' . count($request->categorias ?? [])],
            'descripciones.*' => ['required', 'string'],
            'experiencia' => ['required', 'array', 'size:' . count($request->categorias ?? [])],
            'experiencia.*' => ['required', 'integer', 'min:0'],
            'tarifas' => ['required', 'array', 'size:' . count($request->categorias ?? [])],
            'tarifas.*' => ['required', 'numeric', 'min:0'],
        ]);

        $usuario = Auth::user();
        $especialidades = [];

        foreach ($request->categorias as $i => $categoria) {
            $especialidades[$categoria] = [
                'descripcion' => $request->descripciones[$i],
                'experiencia_anios' => $request->experiencia[$i],
                'tarifa_hora' => $request->tarifas[$i],
                'disponible' => true,
            ];
        }

        // Sincronizar las especialidades
        $usuario->especialidades()->sync($especialidades);

        return redirect()->route('dashboard')
            ->with('success', '¡Perfil completado con éxito! Ahora puedes comenzar a usar la plataforma.');
    }
} 