<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prioridad extends Model
{
    protected $table = 'prioridades';
    protected $fillable = ['nombre'];

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
} 