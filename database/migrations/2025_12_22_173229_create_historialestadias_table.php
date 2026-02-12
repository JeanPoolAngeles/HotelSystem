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
        Schema::create('historialestadias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->unsignedBigInteger('id_reserva');
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_reserva')->references('id')->on('reservas')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historialestadias');
    }
};
