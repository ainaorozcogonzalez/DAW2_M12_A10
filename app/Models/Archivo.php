<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Archivo extends Model
{
    protected $fillable = [
        'comentario_id',
        'url_archivo',
        'tipo'
    ];

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class);
    }

    public function comentario()
    {
        return $this->belongsTo(Comentario::class);
    }

    public static function updateUrls()
    {
        DB::table('archivos')
            ->update([
                'url_archivo' => DB::raw("REPLACE(url_archivo, 'public/archivos', 'storage/archivos')")
            ]);
    }
}
