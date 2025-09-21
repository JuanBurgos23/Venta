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
        Schema::create('venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('cliente')->onDelete('cascade');
            $table->date('fecha_venta');
            $table->decimal('total', 10, 2);
            $table->integer('estado')->default(1); // 1: activo, 0: inactivo
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('producto')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};
