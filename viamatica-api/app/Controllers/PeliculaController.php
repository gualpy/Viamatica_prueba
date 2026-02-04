<?php

namespace App\Controllers;

use App\Services\PeliculaService;
use Illuminate\Http\{JsonResponse, Request};
use App\Helpers\{Respuesta, Mensajes};
use OpenApi\Annotations as OA;

class PeliculaController
{
    public function __construct(
        private PeliculaService $peliculaService
    ) {}

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
        try {
            Respuesta::$codRespuesta = '200';
            Respuesta::$mensaje = Mensajes::$registroExitoso;
            Respuesta::$data = $this->peliculaService->listar();
            return Respuesta::retornarRespuesta();
            //return response()->json($this->peliculaService->listar());
        } catch (\Exception $e) {
            Respuesta::$codRespuesta = '500';
            return response()->json([
                'error' => 'Error al listar las películas',
                'message' => $e->getMessage()
            ], 500);
        }
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
        try {
            Respuesta::$codRespuesta = '200';
            Respuesta::$mensaje = Mensajes::$listado;
            Respuesta::$data = $this->peliculaService->obtener($id);
            return Respuesta::retornarRespuesta();
            //return response()->json($this->peliculaService->obtener($id));
        } catch (\Exception $e) {
            Respuesta::$codRespuesta = '500';
            return response()->json([
                'error' => 'Error al obtener la película',
                'message' => $e->getMessage()
            ], 500);
        }
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
        //dd("hola");
        try {
            $data = $request->validate([
                'nombre' => ['required', 'string', 'max:255'],
                'duracion' => ['required', 'integer', 'min:1'],
            ]);
            $pelicula = $this->peliculaService->crear($data);
            Respuesta::$codRespuesta = '201';
            Respuesta::$mensaje = Mensajes::$creacionExitosa;
            Respuesta::$data = $pelicula;
            return Respuesta::retornarRespuesta();
            //return response()->json($pelicula, 201);
        } catch (\Exception $e) {
            //Respuesta::$codRespuesta = '500';
            return response()->json([
                'error' => 'Error al crear la película',
                'message' => $e->getMessage()
            ], 500);
        }
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
        try {
            $data = $request->validate([
                'nombre' => ['sometimes', 'required', 'string', 'max:255'],
                'duracion' => ['sometimes', 'required', 'integer', 'min:1'],
            ]);

            $pelicula = $this->peliculaService->obtenerModelo($id);
            $pelicula = $this->peliculaService->actualizar($pelicula, $data);
            Respuesta::$codRespuesta = '200';
            Respuesta::$mensaje = Mensajes::$ActualizacionExitosa;
            Respuesta::$data = $pelicula;
            return Respuesta::retornarRespuesta();
            //return response()->json($pelicula);
        } catch (\Exception $e) {
            Respuesta::$codRespuesta = '500';
            return response()->json([
                'error' => 'Error al actualizar la película',
                'message' => $e->getMessage()
            ], 500);
        }
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
        try {
            $pelicula = $this->peliculaService->obtenerModelo($id);
            $this->peliculaService->eliminar($pelicula);
            Respuesta::$codRespuesta = '200';
            Respuesta::$mensaje = Mensajes::$EliminacionExitosa;
            //return response()->json(['message' => 'Película eliminada correctamente']);
            return Respuesta::retornarRespuesta();
        } catch (\Exception $e) {
            Respuesta::$codRespuesta = '500';
            return response()->json([
                'error' => 'Error al eliminar la película',
                'message' => $e->getMessage()
            ], 500);
        }
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
        try {

            $data = $request->validate([
                'nombre' => ['required', 'string', 'max:255'],
            ]);
            Respuesta::$codRespuesta = '200';
            Respuesta::$mensaje = Mensajes::$registroExitoso;
            Respuesta::$data = $this->peliculaService->buscarPorNombre($data['nombre']);
            return Respuesta::retornarRespuesta();
            //return response()->json($this->peliculaService->buscarPorNombre($data['nombre']));
        } catch (\Exception $e) {
            Respuesta::$codRespuesta = '500';
            return response()->json([
                'error' => 'Error al buscar películas por nombre',
                'message' => $e->getMessage()
            ], 500);
        }
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
        try {
            Respuesta::$codRespuesta = '200';
            Respuesta::$mensaje = Mensajes::$registroExitoso;
            $data = $request->validate([
                'fecha_publicacion' => ['required', 'date'],
            ]);
            return response()->json($this->peliculaService->buscarPorFechaPublicacion($data['fecha_publicacion']));
        } catch (\Exception $e) {
            Respuesta::$codRespuesta = '500';
            return response()->json([
                'error' => 'Error al buscar películas por fecha de publicación',
                'message' => $e->getMessage()
            ], 500);
            return Respuesta::retornarRespuesta();
        }
    }
}
