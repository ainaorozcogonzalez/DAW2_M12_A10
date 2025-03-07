<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $fillable = [
        'incidencia_id',
        'url_archivo',
        'tipo'
    ];

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class);
    }
}
