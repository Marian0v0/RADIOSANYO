<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sgies_solicitud', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bodega')->constrained('sgies_bodegas', 'id')->onDelete('cascade'); 
            $table->timestamp('fecha_solicitud')->useCurrent();
            $table->timestamp('fecha_cierre')->nullable();
            $table->tinyInteger('resuelto')->default(0);
            
            // Índice para mejorar búsquedas, pero NO unique
            $table->index('id_bodega');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sgies_solicitud');
    }
};