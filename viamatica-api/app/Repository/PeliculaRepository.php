<?php

namespace App\Repository;

use App\Model\Pelicula;
use Illuminate\Database\Eloquent\Collection;

class PeliculaRepository
{
    public function all(): Collection
    {
        return Pelicula::query()->get();
    }

    public function findOrFail(int $id): Pelicula
    {
        return Pelicula::query()->findOrFail($id);
    }

    public function create(array $data): Pelicula
    {
        return Pelicula::query()->create($data);
    }

    public function update(Pelicula $pelicula, array $data): Pelicula
    {
        $pelicula->fill($data);
        $pelicula->save();

        return $pelicula;
    }

    public function delete(Pelicula $pelicula): void
    {
        $pelicula->delete();
    }

    public function searchByNombre(string $nombre): Collection
    {
        return Pelicula::query()
            ->where('nombre', 'like', '%' . $nombre . '%')
            ->get();
    }
}
