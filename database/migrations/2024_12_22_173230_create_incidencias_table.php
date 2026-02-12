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
            $table->string('descripcion', 255);
            $table->date('hora')->nullable();
            $table->integer('estado')->default(0);
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_habitacion');
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_habitacion')->references('id')->on('habitacions')->onDelete('cascade')->onUpdate('cascade');
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
