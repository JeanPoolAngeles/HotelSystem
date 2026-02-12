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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50);
            $table->string('nombre', 255);
            $table->text('descripcion', 255);
            $table->decimal('precio', 10, 2);
            $table->integer('estado')->default(1); // 0: no disponible 1: disponible
            $table->unsignedBigInteger('id_habitacion')->nullable();
            $table->timestamps();
            
            $table->foreign('id_habitacion')->references('id')->on('habitacions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
