<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoIncidencia extends Model
{
    protected $fillable = ['nombre'];

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
} 