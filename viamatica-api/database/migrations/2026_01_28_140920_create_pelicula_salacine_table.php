<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelicula_salacine', function (Blueprint $table) {
            $table->bigIncrements('id_pelicula_sala');
            $table->unsignedBigInteger('id_sala_cine');
            $table->date('fecha_publicacion');
            $table->date('fecha_fin');
            $table->unsignedBigInteger('id_pelicula');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_sala_cine')->references('id_sala')->on('sala_cine');
            $table->foreign('id_pelicula')->references('id_pelicula')->on('pelicula');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelicula_salacine');
    }
};
