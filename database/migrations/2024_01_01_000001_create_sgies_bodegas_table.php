<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sgies_bodegas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->nullable();
            $table->string('password')->nullable(); // Asegúrate de tener esta línea
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sgies_bodegas');
    }
};