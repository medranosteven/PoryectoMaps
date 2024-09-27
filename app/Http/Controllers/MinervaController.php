<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MinervaController extends Controller
{
    public function index()
    {
        try {
            // Consumir la API de zonas y referencias
            $zonasResponse = Http::get('https://ues-api-production.up.railway.app/zonas');
            $referenciasResponse = Http::get('https://ues-api-production.up.railway.app/referencias');

            $departments = [];

            // Verificar que ambas respuestas fueron exitosas
            if ($zonasResponse->successful() && $referenciasResponse->successful()) {
                $zonasData = $zonasResponse->json();
                $referenciasData = $referenciasResponse->json();

                // Asegurarse de que 'data' existe en las respuestas
                if (isset($zonasData['data']) && isset($referenciasData['data'])) {
                    $zonas = $zonasData['data'];
                    $referencias = $referenciasData['data'];

                    // Agrupar referencias por zona
                    foreach ($zonas as $zona) {
                        $zonaId = $zona['id'];
                        $zonaNombre = $zona['nombre'];

                        // Filtrar las referencias que coincidan con la zona actual
                        $filteredReferencias = array_filter($referencias, function($ref) use ($zonaId) {
                            return $ref['zona'] == $zonaId;
                        });

                        // Añadir las referencias agrupadas al departamento correspondiente
                        $departments[$zonaNombre] = array_values($filteredReferencias); // array_values para reindexar
                    }
                } else {
                    // Manejar el caso donde 'data' no está presente
                    Log::error('La respuesta de la API no contiene el campo "data".');
                    return view('minerva', ['error' => 'Error en la estructura de la respuesta de la API.']);
                }
            } else {
                // Manejar errores en las solicitudes
                $error = 'Error al obtener los datos de la API: ';
                if (!$zonasResponse->successful()) {
                    $error .= 'Zonas - ' . $zonasResponse->status() . '; ';
                }
                if (!$referenciasResponse->successful()) {
                    $error .= 'Referencias - ' . $referenciasResponse->status();
                }
                Log::error($error);
                return view('minerva', ['error' => $error]);
            }

            // Pasar los datos de $departments a la vista
            return view('minerva', compact('departments'));

        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje amigable
            Log::error('Error al consumir la API: ' . $e->getMessage());
            return view('minerva', ['error' => 'Ocurrió un error al procesar la solicitud. Inténtalo nuevamente más tarde.']);
        }
    }
}
