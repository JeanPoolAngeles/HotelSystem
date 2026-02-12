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
        Schema::create('habitacions', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->integer('numero');
            $table->integer('capacidad');
            $table->string('slug', 255);
            $table->string('foto')->nullable();
            $table->string('video')->nullable();
            $table->string('descripcion', 255);
            $table->decimal('precio', 10, 2);
            $table->integer('estado')->default(1);  // 0 mantenimiento, 1 disponible , 2 ocupado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitacions');
    }
};
