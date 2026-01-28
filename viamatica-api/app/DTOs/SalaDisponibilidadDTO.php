<?php

namespace App\DTOs;

class SalaDisponibilidadDTO
{
    public function __construct(
        public int $idSala,
        public string $nombreSala,
        public int $totalPeliculas,
        public string $mensaje
    ) {
    }
}
