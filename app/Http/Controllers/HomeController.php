<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirección inteligente según el rol
        if ($user->role === 'farmacia') {
            return redirect('/farmacia');
        } elseif ($user->role === 'medico') {
            return redirect('/citas/agenda');
        }
        
        // Si no tiene rol definido, vista por defecto
        return view('welcome');
    }
}
