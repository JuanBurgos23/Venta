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
        Schema::create('detalle_caja', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('caja_id');
            $table->unsignedInteger('id_tipo_movimiento'); // FK tipo_movimiento.id

            $table->string('movimiento', 50); // compra / venta / pago / ajuste / etc.
            $table->dateTime('fecha_movimiento');

            $table->decimal('monto', 10, 2)->default(0);
            $table->integer('estado')->default(1);

            $table->timestamps();

            $table->index('caja_id');
            $table->index('fecha_movimiento');
            $table->index('id_tipo_movimiento');
            $table->integer('id_movimiento')->nullable();//ID del movimiento relacionado (compra, venta, etc.

            // FK a caja (tabla singular)
            $table->foreign('caja_id')
                ->references('id')->on('caja')
                ->onDelete('cascade');

            // FK a tipo_movimiento
            $table->foreign('id_tipo_movimiento')
                ->references('id')->on('tipo_movimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_caja');
    }
};
