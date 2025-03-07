<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = 'sedes';
    protected $fillable = [
        'nombre',
        'direccion'
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }
}
