<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\PreferenciaUsuario;
use App\Models\Usuario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use ZipArchive;

class PerfilController extends Controller
{
    /**
     * Muestra el perfil del usuario.
     */
    public function show()
    {
        $usuario = Auth::user();
        $servicios = $usuario->serviciosOfrecidos()
            ->with('categoria')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $especialidades = $usuario->especialidades;
        $preferencias = $usuario->preferencias;
        
        return view('perfil.show', compact('usuario', 'servicios', 'especialidades', 'preferencias'));
    }
    
    /**
     * Muestra el formulario para editar el perfil.
     */
    public function edit()
    {
        $usuario = Auth::user();
        return view('perfil.edit', compact('usuario'));
    }
    
    /**
     * Actualiza el perfil del usuario.
     */
    public function update(Request $request)
    {
        $usuario = Auth::user();
        
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
        
        return redirect()->route('perfil.show')
            ->with('success', 'Perfil actualizado correctamente.');
    }
    
    /**
     * Muestra las preferencias del usuario.
     */
    public function showPreferencias()
    {
        $usuario = Auth::user();
        $preferencias = $usuario->preferencias;
        $categorias = Categoria::where('activo', true)->get();
        $usuarioCategorias = $usuario->intereses()->pluck('categorias.id_categoria')->toArray();
        
        // Add categorías recomendadas
        $categoriasRecomendadas = Categoria::where('activo', true)
            ->whereNotIn('id_categoria', $usuarioCategorias)
            ->limit(6)
            ->get();
        
        return view('perfil.preferencias', compact('usuario', 'preferencias', 'categorias', 'usuarioCategorias', 'categoriasRecomendadas'));
    }
    
    /**
     * Actualiza las preferencias del usuario.
     */
    public function updatePreferencias(Request $request)
    {
        $usuario = Auth::user();
        
        // Handle single preference creation from modal
        if ($request->filled('hobby') && $request->filled('descripcion')) {
            PreferenciaUsuario::create([
                'id_usuario' => $usuario->id_usuario,
                'hobby' => $request->hobby,
                'descripcion' => $request->descripcion,
            ]);
            
            return redirect()->route('perfil.preferencias')
                ->with('success', 'Preferencia agregada correctamente.');
        }
        
        // Handle bulk update from form
        if ($request->filled('hobbies')) {
            // Eliminar preferencias antiguas
            $usuario->preferencias()->delete();
            
            // Agregar nuevas preferencias
            foreach ($request->hobbies as $index => $hobby) {
                if (!empty($hobby)) {
                    PreferenciaUsuario::create([
                        'id_usuario' => $usuario->id_usuario,
                        'hobby' => $hobby,
                        'descripcion' => $request->descripcion_hobbies[$index] ?? null,
                    ]);
                }
            }
        }
        
        // Actualizar categorías de interés
        if ($request->has('intereses')) {
            $usuario->intereses()->sync($request->intereses);
        } else {
            $usuario->intereses()->detach();
        }
        
        return redirect()->route('perfil.preferencias')
            ->with('success', 'Preferencias actualizadas correctamente.');
    }
    
    /**
     * Muestra las especialidades del usuario.
     */
    public function showEspecialidades()
    {
        $usuario = Auth::user();
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();
        $especialidades = $usuario->especialidades()->get();
        
        return view('perfil.especialidades', compact('usuario', 'categorias', 'especialidades'));
    }
    
    /**
     * Actualiza las especialidades del usuario.
     */
    public function updateEspecialidades(Request $request)
    {
        $usuario = Auth::user();
        
        // Handle single specialty creation from modal
        if ($request->filled('categoria_id') && $request->filled('descripcion')) {
            // Verificar si ya existe esta especialidad para este usuario
            $existingEspecialidad = $usuario->especialidades()
                ->wherePivot('id_categoria', $request->categoria_id)
                ->exists();
                
            if ($existingEspecialidad) {
                // Actualizar la especialidad existente
                $usuario->especialidades()->updateExistingPivot($request->categoria_id, [
                    'descripcion' => $request->descripcion,
                    'experiencia_anios' => $request->experiencia_anios,
                    'tarifa_hora' => $request->tarifa_hora,
                    'disponible' => $request->boolean('disponible', true),
                ]);
                
                return redirect()->route('perfil.especialidades')
                    ->with('success', 'Especialidad actualizada correctamente.');
            } else {
                // Crear nueva especialidad
                $usuario->especialidades()->attach($request->categoria_id, [
                    'descripcion' => $request->descripcion,
                    'experiencia_anios' => $request->experiencia_anios,
                    'tarifa_hora' => $request->tarifa_hora,
                    'disponible' => $request->boolean('disponible', true),
                ]);
                
                return redirect()->route('perfil.especialidades')
                    ->with('success', 'Especialidad agregada correctamente.');
            }
        }
        
        // Handle bulk update from form
        $especialidades = [];
        
        if ($request->has('categorias')) {
            foreach ($request->categorias as $index => $idCategoria) {
                $especialidades[$idCategoria] = [
                    'descripcion' => $request->descripcion[$index],
                    'experiencia_anios' => $request->experiencia[$index],
                    'tarifa_hora' => $request->tarifa[$index],
                    'disponible' => isset($request->disponible[$index]),
                ];
            }
        }
        
        $usuario->especialidades()->sync($especialidades);
        
        return redirect()->route('perfil.especialidades')
            ->with('success', 'Especialidades actualizadas correctamente.');
    }
    
    /**
     * Descarga la información del usuario en un archivo ZIP.
     */
    public function descargarInformacion()
    {
        $usuario = Auth::user();
        
        // Asegurar que el directorio temp existe
        $tempDir = storage_path('app/public/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        
        // Generar PDF con la información del usuario
        $pdf = PDF::loadView('pdf.usuario_info', [
            'usuario' => $usuario,
            'preferencias' => $usuario->preferencias,
            'especialidades' => $usuario->especialidades,
            'servicios' => $usuario->serviciosOfrecidos,
            'solicitudesRealizadas' => $usuario->solicitudesRealizadas,
            'solicitudesRecibidas' => $usuario->solicitudesRecibidas,
            'valoracionesHechas' => $usuario->valoracionesHechas,
            'valoracionesRecibidas' => $usuario->valoracionesRecibidas,
        ]);
        
        // Guardar PDF temporalmente
        $pdfPath = storage_path('app/public/temp/' . $usuario->id_usuario . '_info.pdf');
        $pdf->save($pdfPath);
        
        // Crear archivo ZIP
        $zipPath = storage_path('app/public/temp/' . $usuario->id_usuario . '_data.zip');
        $zip = new ZipArchive();
        
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $zip->addFile($pdfPath, 'informacion_usuario.pdf');
            $zip->close();
            
            // Descargar archivo ZIP
            return response()->download($zipPath, 'MiInformacion.zip')->deleteFileAfterSend(true);
        }
        
        return redirect()->route('perfil.show')
            ->with('error', 'No se pudo generar el archivo de descarga.');
    }
    
    /**
     * Desactiva la cuenta del usuario.
     */
    public function desactivarCuenta(Request $request)
    {
        $usuario = Auth::user();
        
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.required' => 'La contraseña es obligatoria para confirmar la desactivación.',
            'password.current_password' => 'La contraseña ingresada no es correcta.',
        ]);
        
        // Desactivar cuenta
        $usuario->activo = false;
        $usuario->save();
        
        // Cerrar sesión inmediatamente
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')
            ->with('warning', 'Tu cuenta ha sido desactivada exitosamente. Se ha cerrado tu sesión automáticamente. Para reactivar tu cuenta, contacta con el administrador.');
    }
    
    /**
     * Elimina una preferencia del usuario.
     */
    public function destroyPreferencia(PreferenciaUsuario $preferencia)
    {
        // Verificar que la preferencia pertenece al usuario actual
        if ($preferencia->id_usuario !== Auth::id()) {
            return redirect()->route('perfil.preferencias')
                ->with('error', 'No tienes permiso para eliminar esta preferencia.');
        }
        
        $preferencia->delete();
        
        return redirect()->route('perfil.preferencias')
            ->with('success', 'Preferencia eliminada correctamente.');
    }
    
    /**
     * Elimina una especialidad del usuario.
     */
    public function destroyEspecialidad($idCategoria)
    {
        $usuario = Auth::user();
        
        // Eliminar solo la relación específica entre usuario y categoría
        $usuario->especialidades()->detach($idCategoria);
        
        return redirect()->route('perfil.especialidades')
            ->with('success', 'Especialidad eliminada correctamente.');
    }
} 