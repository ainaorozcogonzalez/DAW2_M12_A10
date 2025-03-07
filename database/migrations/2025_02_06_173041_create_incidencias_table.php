<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('users');
            $table->foreignId('tecnico_id')->nullable()->constrained('users');
            $table->foreignId('sede_id')->constrained('sedes');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('subcategoria_id')->constrained('subcategorias');
            $table->text('descripcion');
            $table->foreignId('estado_id')->constrained('estado_incidencias');
            $table->foreignId('prioridad_id')->constrained('prioridades');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_resolucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
