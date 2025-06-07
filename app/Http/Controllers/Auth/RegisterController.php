<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Maneja la solicitud de registro.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'tipo_documento' => ['required', 'string', 'max:50'],
            'numero_documento' => ['required', 'string', 'max:30', 'unique:usuarios'],
            'genero' => ['required', 'string', 'max:20'],
            'profesion' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'telefono' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'terms' => ['required', 'accepted'],
            'data_policy' => ['required', 'accepted'],
        ], [
            'terms.required' => 'Debes aceptar los términos y condiciones.',
            'terms.accepted' => 'Debes aceptar los términos y condiciones.',
            'data_policy.required' => 'Debes aceptar la política de tratamiento de datos personales.',
            'data_policy.accepted' => 'Debes aceptar la política de tratamiento de datos personales.',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'genero' => $request->genero,
            'profesion' => $request->profesion,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'es_admin' => false,
            'email_verified_at' => now(),
            'activo' => true,
        ]);

        Auth::login($usuario);

        return redirect()->route('dashboard')->with('success', '¡Bienvenido! Tu cuenta ha sido creada correctamente.');
    }
} 