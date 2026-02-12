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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10, 2);
            $table->decimal('pago_con', 10, 2)->default(0)->nullable();
            $table->integer('estado')->default(1);
            $table->unsignedBigInteger('id_reserva');
            $table->unsignedBigInteger('id_caja');
            $table->timestamps();

            $table->foreign('id_reserva')->references('id')->on('reservas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_caja')->references('id')->on('cajas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
