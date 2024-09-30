<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Importa la clase Request
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MinervaController extends Controller
{
    // Método para manejar las zonas
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
                    return view('zonas', ['error' => 'Error en la estructura de la respuesta de la API.']);
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
                return view('zonas', ['error' => $error]);
            }

            /* Definir los arrays de imágenes (si son necesarios)
            $images = [
                ['url' => 'https://via.placeholder.com/502x677', 'caption' => 'Imagen principal'],
                ['url' => 'https://via.placeholder.com/346x332', 'caption' => 'Imagen secundaria'],
                ['url' => 'https://via.placeholder.com/346x332', 'caption' => 'Imagen secundaria'],
                ['url' => 'https://via.placeholder.com/346x332', 'caption' => 'Imagen secundaria'],
                ['url' => 'https://via.placeholder.com/346x332', 'caption' => 'Imagen secundaria']
            ];

            $highlightedImages = [
                [
                    'url' => 'https://via.placeholder.com/712x677',
                    'title' => 'Auditorio 1',
                    'location' => 'CRQV+V24, San Miguel',
                    'address' => 'Frente a la Plaza Roque Daltón, Costado Poniente del Parqueo de Visitantes.',
                    'capacity' => '250 personas'
                ]
            ];*/

            // Pasar todos los datos a la vista
            return view('zonas', compact('departments', 'images', 'highlightedImages'));

        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje amigable
            Log::error('Error al consumir la API: ' . $e->getMessage());
            return view('zonas', ['error' => 'Ocurrió un error al procesar la solicitud. Inténtalo nuevamente más tarde.']);
        }
    }

    // Método para manejar las aulas
    public function getAulas()
    {
        try {
            // Consumir la API de aulas
            $aulasResponse = Http::get('https://ues-api-production.up.railway.app/aulas');

            $aulas = [];

            // Verificar que la respuesta fue exitosa
            if ($aulasResponse->successful()) {
                $aulasData = $aulasResponse->json();

                // Asegurarse de que 'data' existe en la respuesta
                if (isset($aulasData['data'])) {
                    $aulas = $aulasData['data'];

                    // Opcional: Mapear las claves si la API usa nombres diferentes
                    // $aulas = array_map(function($aula) {
                    //     return [
                    //         'id' => $aula['id'] ?? null,
                    //         'nombre' => $aula['name'] ?? 'Sin Nombre',
                    //         'capacidad' => $aula['capacity'] ?? 'Sin Capacidad',
                    //         'zona' => $aula['zone'] ?? 'Sin Zona',
                    //         // Añade más campos según sea necesario
                    //     ];
                    // }, $aulas);

                } else {
                    Log::error('La respuesta de la API de aulas no contiene el campo "data".');
                    return view('aulas', ['error' => 'Error en la estructura de la respuesta de la API de aulas.']);
                }
            } else {
                // Manejar el error
                $error = 'Error al obtener los datos de la API de aulas: ' . $aulasResponse->status();
                Log::error($error);
                return view('aulas', ['error' => $error]);
            }

            // Pasar los datos de $aulas a la vista
            return view('aulas', compact('aulas'));

        } catch (\Exception $e) {
            // Registrar el error y mostrar un mensaje amigable
            Log::error('Error al consumir la API de aulas: ' . $e->getMessage());
            return view('aulas', ['error' => 'Ocurrió un error al procesar la solicitud de aulas. Inténtalo nuevamente más tarde.']);
        }
    }
}