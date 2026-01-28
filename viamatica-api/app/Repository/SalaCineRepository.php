<?php

namespace App\Repository;

use App\Model\SalaCine;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SalaCineRepository
{
    public function findByNombre(string $nombre): Collection
    {
        return SalaCine::query()
            ->where('nombre', 'like', '%' . $nombre . '%')
            ->get();
    }

    public function contarPeliculas(int $idSala): int
    {
        $result = DB::select('CALL sp_contar_peliculas_sala(?)', [$idSala]);
        if (empty($result)) {
            return 0;
        }

        return (int) ($result[0]->total ?? 0);
    }
}
