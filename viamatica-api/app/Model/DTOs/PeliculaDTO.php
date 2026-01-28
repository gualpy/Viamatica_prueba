<?php

namespace App\Model\DTOs;

class PeliculaDTO
{
    public function __construct(
        public int $id,
        public string $nombre,
        public int $duracion
    ) {
    }
}
