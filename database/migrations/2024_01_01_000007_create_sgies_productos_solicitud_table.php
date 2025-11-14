<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sgies_productos_solicitud', function (Blueprint $table) {
            $table->foreignId('id_solicitud')->constrained('sgies_solicitud', 'id')->onDelete('cascade');
            $table->string('referencia_producto', 255);
            $table->integer('cantidad_solicitada');
            
            $table->foreign('referencia_producto', 'referencia_producto_solicitud')
                  ->references('referencia')
                  ->on('sgies_productos')->onDelete('cascade');
            
            // Clave primaria compuesta
            $table->primary(['id_solicitud', 'referencia_producto'], 'productos_solicitud_pk');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sgies_productos_solicitud');
    }
};