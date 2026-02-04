<?php

namespace App\Services;

use App\Repository\PeliculaRepository;
use App\Repository\PeliculaSalaCineRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Pelicula;
use App\Model\DTOs\PeliculaDTO;
use Illuminate\Support\Facades\DB;

class PeliculaService
{
    public function __construct(
        private PeliculaRepository $peliculaRepository,
        private PeliculaSalaCineRepository $peliculaSalaCineRepository
    ) {
    }

    public function listar(): Collection
    {
        return $this->peliculaRepository->all();
    }

    public function obtener(int $id): PeliculaDTO
    {
        return $this->toDTO($this->peliculaRepository->findOrFail($id));
    }

    public function obtenerModelo(int $id): Pelicula
    {
        return $this->peliculaRepository->findOrFail($id);
    }

    public function crear(array $data): Pelicula
    {
        DB::beginTransaction();
        try {
            $pelicula = $this->peliculaRepository->create($data);
            DB::commit();

            return $pelicula;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al crear la película: " . $e->getMessage());
        }
    }

    public function actualizar(Pelicula $pelicula, array $data): Pelicula
    {
        DB::beginTransaction();
        try {
            $pelicula = $this->peliculaRepository->update($pelicula, $data);
            DB::commit();

            return $pelicula;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al actualizar la película: " . $e->getMessage());
        }
    }

    public function eliminar(Pelicula $pelicula): void
    {
        DB::beginTransaction();
        try {
            $this->peliculaRepository->delete($pelicula);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al eliminar la película: " . $e->getMessage());
        }
    }

    public function buscarPorNombre(string $nombre): Collection
    {
        return $this->peliculaRepository->searchByNombre($nombre);
    }

    public function buscarPorFechaPublicacion(string $fechaPublicacion): Collection
    {
        return $this->peliculaSalaCineRepository->findByFechaPublicacion($fechaPublicacion);
    }

    private function toDTO(Pelicula $pelicula): PeliculaDTO
    {
        return new PeliculaDTO(
            $pelicula->id_pelicula,
            $pelicula->nombre,
            (int) $pelicula->duracion
        );
    }
}
