<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Archivo;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comentario_id')->constrained('comentarios')->onDelete('cascade');
            $table->string('url_archivo');
            $table->enum('tipo', ['imagen', 'pdf', 'otro']);
            $table->timestamps();
        });
        DB::table('archivos')
            ->update([
                'url_archivo' => DB::raw("REPLACE(url_archivo, 'private/public/archivos/', 'storage/archivos/')")
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
