<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalaCine extends Model
{
    use SoftDeletes;

    protected $table = 'sala_cine';
    protected $primaryKey = 'id_sala';

    protected $fillable = [
        'nombre',
        'estado',
    ];

    public function peliculas(): HasMany
    {
        return $this->hasMany(PeliculaSalaCine::class, 'id_sala_cine', 'id_sala');
    }
}
