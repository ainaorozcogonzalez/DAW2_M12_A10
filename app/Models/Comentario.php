<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'incidencia_id',
        'usuario_id',
        'mensaje'
    ];

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
