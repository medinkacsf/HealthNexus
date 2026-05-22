<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            DB::table('audit_logs')->insert([
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'navegador' => substr($request->userAgent(), 0, 255),
                'action' => 'LOGIN_EXITOSO',
                'tipo' => 'login',
                'descripcion' => 'Inicio de sesion: ' . $request->email,
                'exitoso' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Redirigir según rol
            $rol = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', Auth::id())
                ->value('roles.name');

            $destinos = [
                'SuperAdmin' => '/superadmin',
                'Nivel_A' => '/nivel-a',
                'Nivel_B' => '/nivel-b',
                'Nivel_C' => '/nivel-c',
                'Farmacia' => '/farmacia',
                'Enfermeria' => '/enfermeria',
                'Gobierno' => '/gobierno',
                'RH' => '/rh',
            ];

            Log::info("LOGIN REDIRECT: user=" . Auth::user()->name . " rol=" . $rol . " destino=" . ($destinos[$rol] ?? "/dashboard"));
            return redirect($destinos[$rol] ?? '/dashboard');
        }

        DB::table('audit_logs')->insert([
            'user_id' => null,
            'ip_address' => $request->ip(),
            'navegador' => substr($request->userAgent(), 0, 255),
            'action' => 'LOGIN_FALLIDO',
            'tipo' => 'login_fallido',
            'descripcion' => 'Intento fallido: ' . $request->email,
            'exitoso' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    public function logout()
    {
        DB::table('audit_logs')->insert([
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
            'navegador' => substr(request()->userAgent(), 0, 255),
            'action' => 'LOGOUT',
            'tipo' => 'logout',
            'descripcion' => 'Cierre de sesion',
            'exitoso' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Auth::logout();
        return redirect('/login');
    }

    public function apiLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $role = $user->roles->first();
            return response()->json(['token' => $user->createToken('healthnexus')->plainTextToken, 'user' => $user, 'role' => $role]);
        }
        return response()->json(['error' => 'Credenciales incorrectas'], 401);
    }
}
