<?php

namespace App\Services;

use App\Repository\PeliculaRepository;
use App\Repository\PeliculaSalaCineRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Pelicula;

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

    public function obtener(int $id): Pelicula
    {
        return $this->peliculaRepository->findOrFail($id);
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
        return $this->peliculaRepository->searchByNombre($nombre);
    }

    public function buscarPorFechaPublicacion(string $fechaPublicacion): Collection
    {
        return $this->peliculaSalaCineRepository->findByFechaPublicacion($fechaPublicacion);
    }
}
