<?php

namespace App\Model;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelicula extends Model
{
    use SoftDeletes;

    protected $table = 'pelicula';
    protected $primaryKey = 'id_pelicula';

    protected $fillable = [
        'nombre',
        'duracion',
    ];

    public function salas(): HasMany
    {
        return $this->hasMany(PeliculaSalaCine::class, 'id_pelicula', 'id_pelicula');
    }
}
