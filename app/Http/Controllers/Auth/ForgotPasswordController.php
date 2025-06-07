<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */



    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Constructor sin middleware
    }

    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::broker('usuarios')->sendResetLink(
            $this->credentials($request)
        );

        return $status === Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $status)
                    : $this->sendResetLinkFailedResponse($request, $status);
    }

    /**
     * Validate the email for the given request.
     */
    protected function validateEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required', 
                'email', 
                'exists:usuarios,email'
            ],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser una dirección de correo válida.',
            'email.exists' => 'No encontramos ninguna cuenta con este correo electrónico.',
        ]);
    }

    /**
     * Get the needed authentication credentials from the request.
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    /**
     * Get the response for a successful password reset link.
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', '¡Hemos enviado un enlace de restablecimiento a tu correo electrónico!');
    }

    /**
     * Get the response for a failed password reset link.
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        throw ValidationException::withMessages([
            'email' => [$this->getErrorMessage($response)],
        ]);
    }

    /**
     * Get the error message for the given response.
     */
    protected function getErrorMessage($response)
    {
        return match($response) {
            Password::INVALID_USER => 'No encontramos ninguna cuenta con este correo electrónico.',
            Password::RESET_THROTTLED => 'Por favor espera antes de solicitar otro enlace de restablecimiento.',
            default => 'Ha ocurrido un error. Inténtalo de nuevo más tarde.',
        };
    }
} 