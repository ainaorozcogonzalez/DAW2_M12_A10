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
        'estado_id',
        'prioridad_id',
        'fecha_creacion',
        'fecha_resolucion'
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_resolucion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class, 'subcategoria_id');
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoIncidencia::class, 'estado_id');
    }

    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class, 'prioridad_id');
    }
}
