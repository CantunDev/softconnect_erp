<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Primero validamos el formato del email
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Verificamos si el usuario existe
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->sendFailedLoginResponse($request, 'email', 'El correo electrónico no está registrado');
        }

        // Verificamos la contraseña
        if (!Hash::check($request->password, $user->password)) {
            return $this->sendFailedLoginResponse($request, 'password', 'La contraseña es incorrecta');
        }

        // Intentamos la autenticación
        try {
            $request->authenticate();
            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard', absolute: false));
        } catch (ValidationException $e) {
            return $this->sendFailedLoginResponse($request, 'email', 'Credenciales inválidas');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Handle failed login attempts with specific field errors.
     */
    protected function sendFailedLoginResponse(Request $request, string $field, string $message): RedirectResponse
    {
        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([$field => $message]);
    }

    /**
     * API method to check if email exists (for AJAX validation)
     */
    public function checkEmail(Request $request): Response
    {
        $request->validate(['email' => 'required|email']);

        $exists = User::where('email', $request->email)->exists();

        return response([
            'exists' => $exists,
            'message' => $exists 
                ? 'El correo electrónico es válido' 
                : 'El correo electrónico no está registrado'
        ]);
    }
}