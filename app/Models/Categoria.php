<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = [
        'nombre'
    ];

    public function subcategorias()
    {
        return $this->hasMany(Subcategoria::class);
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
}
