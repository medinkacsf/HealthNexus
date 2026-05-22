<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IAController extends Controller
{
    public function index()
    {
        return view('ia.panel');
    }

    public function predecir(Request $request)
    {
        $sintomas = [
            'fiebre' => $request->input('fiebre', 0),
            'tos_seca' => $request->input('tos_seca', 0),
            'dolor_cabeza' => $request->input('dolor_cabeza', 0),
        ];

        $respuesta = Http::post('http://127.0.0.1:8000/predict', $sintomas);
        $prediccion = $respuesta->successful() ? $respuesta->json() : ['error' => 'No se pudo conectar al motor de IA'];

        return view('ia.panel', compact('prediccion', 'sintomas'));
    }

    public function getAlertas()
    {
        try {
            $respuesta = Http::timeout(5)->get('http://127.0.0.1:8000/anomalias');
            return response()->json($respuesta->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Motor IA desconectado'], 503);
        }
    }

    public function validarReceta(Request $request)
    {
        $medicamento = $request->input('medicamento');
        
        try {
            $respuesta = Http::timeout(5)->get("http://127.0.0.1:8000/validar_receta/{$medicamento}");
            return response()->json($respuesta->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Motor IA desconectado'], 503);
        }
    }

    public function detectarFuga(Request $request)
    {
        $jeringas = $request->input('jeringas');
        $gasas = $request->input('gasas');

        try {
            $respuesta = Http::timeout(5)->get("http://127.0.0.1:8000/detectar_anomalia/{$jeringas}/{$gasas}");
            return response()->json($respuesta->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Motor IA desconectado'], 503);
        }
    }
}
