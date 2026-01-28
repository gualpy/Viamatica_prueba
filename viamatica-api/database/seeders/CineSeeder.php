<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CineSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $salas = [
            ['id_sala' => 1, 'nombre' => 'Sala 1', 'estado' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id_sala' => 2, 'nombre' => 'Sala 2', 'estado' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id_sala' => 3, 'nombre' => 'Sala 3', 'estado' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id_sala' => 4, 'nombre' => 'Sala 4', 'estado' => true, 'created_at' => $now, 'updated_at' => $now],
        ];

        $peliculas = [
            ['id_pelicula' => 1, 'nombre' => 'Matrix', 'duracion' => 136, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 2, 'nombre' => 'Inception', 'duracion' => 148, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 3, 'nombre' => 'Interstellar', 'duracion' => 169, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 4, 'nombre' => 'The Dark Knight', 'duracion' => 152, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 5, 'nombre' => 'The Prestige', 'duracion' => 130, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 6, 'nombre' => 'Dune', 'duracion' => 155, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 7, 'nombre' => 'Arrival', 'duracion' => 116, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 8, 'nombre' => 'Blade Runner 2049', 'duracion' => 164, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 9, 'nombre' => 'Tenet', 'duracion' => 150, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 10, 'nombre' => 'Avatar', 'duracion' => 162, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 11, 'nombre' => 'Gladiator', 'duracion' => 155, 'created_at' => $now, 'updated_at' => $now],
            ['id_pelicula' => 12, 'nombre' => 'Joker', 'duracion' => 122, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('sala_cine')->truncate();
        DB::table('pelicula')->truncate();
        DB::table('pelicula_salacine')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        DB::table('sala_cine')->insert($salas);
        DB::table('pelicula')->insert($peliculas);

        $peliculaSala = [
            // Sala 1 (2 peliculas) -> Sala disponible
            ['id_sala_cine' => 1, 'id_pelicula' => 1, 'fecha_publicacion' => '2026-01-10', 'fecha_fin' => '2026-01-20', 'created_at' => $now, 'updated_at' => $now],
            ['id_sala_cine' => 1, 'id_pelicula' => 2, 'fecha_publicacion' => '2026-01-11', 'fecha_fin' => '2026-01-21', 'created_at' => $now, 'updated_at' => $now],

            // Sala 2 (4 peliculas) -> Sala con 4 peliculas asignadas
            ['id_sala_cine' => 2, 'id_pelicula' => 3, 'fecha_publicacion' => '2026-01-12', 'fecha_fin' => '2026-01-22', 'created_at' => $now, 'updated_at' => $now],
            ['id_sala_cine' => 2, 'id_pelicula' => 4, 'fecha_publicacion' => '2026-01-13', 'fecha_fin' => '2026-01-23', 'created_at' => $now, 'updated_at' => $now],
            ['id_sala_cine' => 2, 'id_pelicula' => 5, 'fecha_publicacion' => '2026-01-14', 'fecha_fin' => '2026-01-24', 'created_at' => $now, 'updated_at' => $now],
            ['id_sala_cine' => 2, 'id_pelicula' => 6, 'fecha_publicacion' => '2026-01-15', 'fecha_fin' => '2026-01-25', 'created_at' => $now, 'updated_at' => $now],

            // Sala 3 (6 peliculas) -> Sala no disponible
            ['id_sala_cine' => 3, 'id_pelicula' => 7, 'fecha_publicacion' => '2026-01-16', 'fecha_fin' => '2026-01-26', 'created_at' => $now, 'updated_at' => $now],
            ['id_sala_cine' => 3, 'id_pelicula' => 8, 'fecha_publicacion' => '2026-01-17', 'fecha_fin' => '2026-01-27', 'created_at' => $now, 'updated_at' => $now],
            ['id_sala_cine' => 3, 'id_pelicula' => 9, 'fecha_publicacion' => '2026-01-18', 'fecha_fin' => '2026-01-28', 'created_at' => $now, 'updated_at' => $now],
            ['id_sala_cine' => 3, 'id_pelicula' => 10, 'fecha_publicacion' => '2026-01-19', 'fecha_fin' => '2026-01-29', 'created_at' => $now, 'updated_at' => $now],
            ['id_sala_cine' => 3, 'id_pelicula' => 11, 'fecha_publicacion' => '2026-01-20', 'fecha_fin' => '2026-01-30', 'created_at' => $now, 'updated_at' => $now],
            ['id_sala_cine' => 3, 'id_pelicula' => 12, 'fecha_publicacion' => '2026-01-21', 'fecha_fin' => '2026-01-31', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('pelicula_salacine')->insert($peliculaSala);
    }
}
