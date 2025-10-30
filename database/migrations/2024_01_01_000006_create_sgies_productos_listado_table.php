<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sgies_productos_listado', function (Blueprint $table) {
            $table->string('referencia_producto', 255);
            $table->foreignId('id_listado_contable')->constrained('sgies_listado_contable', 'id');
            $table->boolean('cambio_precio')->default(false);
            $table->boolean('nuevo_producto')->default(false);
            
            $table->foreign('referencia_producto', 'referencia_producto')
                  ->references('referencia')
                  ->on('sgies_productos');
            
            // Clave primaria compuesta
            $table->primary(['referencia_producto', 'id_listado_contable'], 'productos_listado_pk');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sgies_productos_listado');
    }
};