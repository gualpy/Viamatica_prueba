<?php

namespace App\Controllers;

use App\Services\PeliculaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeliculaController
{
    public function __construct(
        private PeliculaService $peliculaService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->peliculaService->listar());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->peliculaService->obtener($id));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'duracion' => ['required', 'integer', 'min:1'],
        ]);

        $pelicula = $this->peliculaService->crear($data);

        return response()->json($pelicula, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['sometimes', 'required', 'string', 'max:255'],
            'duracion' => ['sometimes', 'required', 'integer', 'min:1'],
        ]);

        $pelicula = $this->peliculaService->obtener($id);
        $pelicula = $this->peliculaService->actualizar($pelicula, $data);

        return response()->json($pelicula);
    }

    public function destroy(int $id): JsonResponse
    {
        $pelicula = $this->peliculaService->obtener($id);
        $this->peliculaService->eliminar($pelicula);

        return response()->json(['message' => 'Película eliminada']);
    }

    public function buscarPorNombre(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
        ]);

        return response()->json($this->peliculaService->buscarPorNombre($data['nombre']));
    }

    public function buscarPorFechaPublicacion(Request $request): JsonResponse
    {
        $data = $request->validate([
            'fecha_publicacion' => ['required', 'date_format:Y-m-d'],
        ]);

        return response()->json($this->peliculaService->buscarPorFechaPublicacion($data['fecha_publicacion']));
    }
}
