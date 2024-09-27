<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MinervaController extends Controller
{
    public function index()
    {
        // Consumir la API de zonas
        $zonasResponse = Http::get('https://ues-api-production.up.railway.app/zonas');
        $referenciasResponse = Http::get('https://ues-api-production.up.railway.app/referencias');

        $departments = [];

        // Verificar que ambas respuestas fueron exitosas
        if ($zonasResponse->successful() && $referenciasResponse->successful()) {
            $zonasData = $zonasResponse->json()['data']; // Zonas
            $referenciasData = $referenciasResponse->json()['data']; // Referencias
            
            // Agrupar referencias por zona
            foreach ($zonasData as $zona) {
                $zonaId = $zona['id'];
                $zonaNombre = $zona['nombre'];

                // Filtrar las referencias que coincidan con la zona actual
                $filteredReferencias = array_filter($referenciasData, function($ref) use ($zonaId) {
                    return $ref['zona'] == $zonaId;
                });

                // Añadir las referencias agrupadas al departamento correspondiente
                $departments[$zonaNombre] = $filteredReferencias;
            }
        }

        // Pasar los datos de $departments a la vista
        return view('minerva', compact('departments'));
    }
}
