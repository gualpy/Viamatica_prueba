<?php

namespace App\Repository;

use App\Model\PeliculaSalaCine;
use Illuminate\Database\Eloquent\Collection;

class PeliculaSalaCineRepository
{
    public function findByFechaPublicacion(string $fechaPublicacion): Collection
    {
        return PeliculaSalaCine::query()
            ->with('pelicula')
            ->whereDate('fecha_publicacion', $fechaPublicacion)
            ->get();
    }
}
