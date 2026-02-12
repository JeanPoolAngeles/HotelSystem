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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 150); // Limpieza, Reparación
            $table->text('descripcion', 255)->nullable();
            $table->integer('estado')->default(0); // 0: Pendiente, 1: Completado
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->unsignedBigInteger('id_habitacion');
            $table->unsignedBigInteger('id_empleado');
            $table->timestamps();

            $table->foreign('id_habitacion')->references('id')->on('habitacions')->onDelete('cascade');
            $table->foreign('id_empleado')->references('id')->on('empleados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
