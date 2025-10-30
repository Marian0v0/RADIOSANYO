<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sgies_productos', function (Blueprint $table) {
            $table->string('referencia', 255)->primary();
            $table->text('nombre');
            $table->integer('cantidad');
            $table->double('precio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sgies_productos');
    }
};