<?php

namespace App\Controllers;

use App\Services\SalaCineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalaCineController
{
    public function __construct(
        private SalaCineService $salaCineService
    ) {
    }

    public function disponibilidadPorNombre(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
        ]);

        return response()->json($this->salaCineService->obtenerDisponibilidadPorNombre($data['nombre']));
    }
}
