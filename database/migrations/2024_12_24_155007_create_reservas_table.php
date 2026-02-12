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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->decimal('monto', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('descripcion');
            $table->string('motivo', 255);
            $table->integer('estado')->default(1); // 0: anulo, 1: Pendiente, 2: Finalizo
            $table->unsignedBigInteger('id_servicio');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->unsignedBigInteger('id_forma')->nullable();
            $table->timestamps();

            $table->foreign('id_servicio')->references('id')->on('servicios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_forma')->references('id')->on('formas')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints(); // Deshabilitar restricciones antes de eliminar

        Schema::dropIfExists('ventas'); // Elimina primero las ventas
        Schema::dropIfExists('historialestadias'); // Luego el historial de estadías
        Schema::dropIfExists('reservas'); // Finalmente la tabla reservas

        Schema::enableForeignKeyConstraints(); // Habilitar restricciones después de eliminar
    }
};
