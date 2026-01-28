<?php

namespace App\Controllers;

use App\Services\SalaCineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class SalaCineController
{
    public function __construct(
        private SalaCineService $salaCineService
    ) {
    }

    /**
     * @OA\Get(
     *   path="/api/salas/disponibilidad",
     *   tags={"Salas"},
     *   summary="Disponibilidad por nombre de sala",
     *   @OA\Parameter(name="nombre", in="query", required=true, @OA\Schema(type="string")),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=422, description="Validación")
     * )
     */
    public function disponibilidadPorNombre(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
        ]);

        return response()->json($this->salaCineService->obtenerDisponibilidadPorNombre($data['nombre']));
    }
}
