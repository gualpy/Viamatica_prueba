<?php

namespace App\Services;

use App\DTOs\SalaDisponibilidadDTO;
use App\Repository\SalaCineRepository;
use Illuminate\Support\Collection;

class SalaCineService
{
    public function __construct(
        private SalaCineRepository $salaCineRepository
    ) {
    }

    public function obtenerDisponibilidadPorNombre(string $nombre): Collection
    {
        $salas = $this->salaCineRepository->findByNombre($nombre);

        return $salas->map(function ($sala) {
            $total = $this->salaCineRepository->contarPeliculas($sala->id_sala);
            $mensaje = $this->resolverMensaje($total);

            return new SalaDisponibilidadDTO(
                $sala->id_sala,
                $sala->nombre,
                $total,
                $mensaje
            );
        });
    }

    private function resolverMensaje(int $total): string
    {
        if ($total < 3) {
            return 'Sala disponible';
        }

        if ($total <= 5) {
            return 'Sala con ' . $total . ' películas asignadas';
        }

        return 'Sala no disponible';
    }
}
