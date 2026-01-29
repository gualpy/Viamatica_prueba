<?php

namespace App\Controllers;

use App\Services\PeliculaService;
use Illuminate\Http\{JsonResponse, Request};
use OpenApi\Annotations as OA;

class PeliculaController
{
    public function __construct(
        private PeliculaService $peliculaService
    ) {
    }

    /**
     * @OA\Get(
     *   path="/api/peliculas",
     *   tags={"Peliculas"},
     *   summary="Listar películas",
     *   @OA\Response(response=200, description="OK")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->peliculaService->listar());
    }

    /**
     * @OA\Get(
     *   path="/api/peliculas/{id}",
     *   tags={"Peliculas"},
     *   summary="Obtener película por ID",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->peliculaService->obtener($id));
    }

    /**
     * @OA\Post(
     *   path="/api/peliculas",
     *   tags={"Peliculas"},
     *   summary="Crear película",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"nombre","duracion"},
     *       @OA\Property(property="nombre", type="string"),
     *       @OA\Property(property="duracion", type="integer")
     *     )
     *   ),
     *   @OA\Response(response=201, description="Creado"),
     *   @OA\Response(response=422, description="Validación")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'duracion' => ['required', 'integer', 'min:1'],
        ]);

        $pelicula = $this->peliculaService->crear($data);

        return response()->json($pelicula, 201);
    }

    /**
     * @OA\Put(
     *   path="/api/peliculas/{id}",
     *   tags={"Peliculas"},
     *   summary="Actualizar película",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="nombre", type="string"),
     *       @OA\Property(property="duracion", type="integer")
     *     )
     *   ),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
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

    /**
     * @OA\Delete(
     *   path="/api/peliculas/{id}",
     *   tags={"Peliculas"},
     *   summary="Eliminar película (soft delete)",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $pelicula = $this->peliculaService->obtener($id);
        $this->peliculaService->eliminar($pelicula);

        return response()->json(['message' => 'Película eliminada']);
    }

    /**
     * @OA\Get(
     *   path="/api/peliculas/buscar/nombre",
     *   tags={"Peliculas"},
     *   summary="Buscar películas por nombre",
     *   @OA\Parameter(name="nombre", in="query", required=true, @OA\Schema(type="string")),
     *   @OA\Response(response=200, description="OK")
     * )
     */
    public function buscarPorNombre(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
        ]);

        return response()->json($this->peliculaService->buscarPorNombre($data['nombre']));
    }

    /**
     * @OA\Get(
     *   path="/api/peliculas/buscar/fecha-publicacion",
     *   tags={"Peliculas"},
     *   summary="Buscar películas por fecha de publicación",
     *   @OA\Parameter(name="fecha_publicacion", in="query", required=true, @OA\Schema(type="string", format="date")),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=422, description="Validación")
     * )
     */
    public function buscarPorFechaPublicacion(Request $request): JsonResponse
    {
        $data = $request->validate([
            'fecha_publicacion' => ['required', 'date_format:Y-m-d'],
        ]);

        return response()->json($this->peliculaService->buscarPorFechaPublicacion($data['fecha_publicacion']));
    }
}
