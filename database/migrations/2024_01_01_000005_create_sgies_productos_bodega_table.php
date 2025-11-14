<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sgies_productos_bodega', function (Blueprint $table) {
            $table->foreignId('id_bodega')->constrained('sgies_bodegas', 'id')->onDelete('cascade');
            $table->string('referencia_producto', 255);
            
            $table->foreign('referencia_producto', 'referencia_producto_bodega')
                  ->references('referencia')
                  ->on('sgies_productos')->onDelete('cascade');
            
            // Clave primaria compuesta para evitar duplicados
            $table->primary(['id_bodega', 'referencia_producto']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sgies_productos_bodega');
    }
};