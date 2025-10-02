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
        Schema::create('producto_almacen', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')->constrained('producto');
            $table->foreignId('almacen_id')->constrained('almacen');
            $table->foreignId('empresa_id')->constrained('empresa');

            $table->string('lote', 100)->nullable()->index();
            $table->integer('id_lote')->nullable();

            // 🔹 este campo ya no debe ser único globalmente
            $table->unsignedBigInteger('producto_compra_id')->nullable();

            $table->decimal('stock', 12, 2)->default(0.00);
            $table->integer('estado')->default(1);

            $table->timestamps();

            // 🔹 índice único: producto+almacén+lote
            $table->unique(['producto_id', 'almacen_id', 'lote'], 'producto_almacen_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_almacen');
    }
};
