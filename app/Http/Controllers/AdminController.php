<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.panel', compact('users', 'roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->roles()->attach($request->role_id);

        $role = Role::find($request->role_id);

        DB::table('audit_logs')->insert([
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'navegador' => substr($request->userAgent(), 0, 255),
            'action' => 'CREACION_USUARIO',
            'tipo' => 'registro',
            'descripcion' => 'Creo usuario: ' . $request->email . ' con rol: ' . $role->name,
            'exitoso' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.panel')->with('success', 'Personal creado exitosamente.');
    }
}
