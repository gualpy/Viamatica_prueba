<?php

namespace App\Services;

use App\Repository\PeliculaRepository;
use App\Repository\PeliculaSalaCineRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Pelicula;
use App\Model\DTOs\PeliculaDTO;
use Illuminate\Support\Collection as SupportCollection;

class PeliculaService
{
    public function __construct(
        private PeliculaRepository $peliculaRepository,
        private PeliculaSalaCineRepository $peliculaSalaCineRepository
    ) {
    }

    public function listar(): Collection
    {
        return $this->peliculaRepository
            ->all()
            ->map(fn (Pelicula $pelicula) => $this->toDTO($pelicula));
    }

    public function obtener(int $id): PeliculaDTO
    {
        return $this->toDTO($this->peliculaRepository->findOrFail($id));
    }

    public function crear(array $data): Pelicula
    {
        return $this->peliculaRepository->create($data);
    }

    public function actualizar(Pelicula $pelicula, array $data): Pelicula
    {
        return $this->peliculaRepository->update($pelicula, $data);
    }

    public function eliminar(Pelicula $pelicula): void
    {
        $this->peliculaRepository->delete($pelicula);
    }

    public function buscarPorNombre(string $nombre): Collection
    {
        return $this->peliculaRepository
            ->searchByNombre($nombre)
            ->map(fn (Pelicula $pelicula) => $this->toDTO($pelicula));
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
