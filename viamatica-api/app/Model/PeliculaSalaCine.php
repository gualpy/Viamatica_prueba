<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeliculaSalaCine extends Model
{
    use SoftDeletes;

    protected $table = 'pelicula_salacine';
    protected $primaryKey = 'id_pelicula_sala';

    protected $fillable = [
        'id_sala_cine',
        'fecha_publicacion',
        'fecha_fin',
        'id_pelicula',
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'fecha_fin' => 'date',
    ];

    public function pelicula(): BelongsTo
    {
        return $this->belongsTo(Pelicula::class, 'id_pelicula', 'id_pelicula');
    }

    public function sala(): BelongsTo
    {
        return $this->belongsTo(SalaCine::class, 'id_sala_cine', 'id_sala');
    }
}
