<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_contar_peliculas_sala');
        DB::unprepared('CREATE PROCEDURE sp_contar_peliculas_sala(IN salaId BIGINT)
            BEGIN
                SELECT COUNT(*) AS total
                FROM pelicula_salacine
                WHERE id_sala_cine = salaId AND deleted_at IS NULL;
            END');
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_contar_peliculas_sala');
    }
};
