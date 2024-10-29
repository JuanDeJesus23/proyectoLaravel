<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function bienvenido()
    {
        return view('bienvenido');
    }
    

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

       
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                // Autenticación exitosa
                return redirect()->intended('/bienvenido');
            } else {
                // Autenticación fallida, puede ser por contraseña incorrecta
                return back()->withErrors([
                    'password' => 'La contraseña ingresada es incorrecta.',
                ]);
            }
        } catch (ValidationException $e) {
            // Manejar excepciones específicas de validación
            return back()->withErrors([
                'password' => 'Ocurrió un error al procesar la contraseña.',
            ]);
        } catch (\Exception $e) {
            // Manejar otras excepciones generales
            return back()->withErrors([
                'general' => 'Ocurrió un error inesperado. Inténtalo de nuevo más tarde.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Cierra la sesión del usuario

        $request->session()->invalidate(); // Invalida la sesión

        $request->session()->regenerateToken(); // Regenera el token CSRF

        return redirect('/login'); // Redirige a la página de inicio de sesión
    }
}
