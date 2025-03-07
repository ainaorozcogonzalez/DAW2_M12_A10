<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $fillable = [
        'cliente_id',
        'tecnico_id',
        'sede_id',
        'categoria_id',
        'subcategoria_id',
        'descripcion',
        'estado',
        'prioridad',
        'fecha_creacion',
        'fecha_resolucion'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
