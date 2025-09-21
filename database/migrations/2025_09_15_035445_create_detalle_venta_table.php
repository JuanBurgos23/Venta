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
        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->id();

            // Relación con la cabecera
            $table->foreignId('venta_id')->constrained('venta')->onDelete('cascade');

            // Producto y unidad de medida
            $table->foreignId('producto_id')->constrained('producto')->onDelete('cascade');
            $table->foreignId('unidad_medida_id')->nullable()->constrained('unidad_medida')->onDelete('set null');

            // Datos de la venta
            $table->decimal('cantidad', 12, 2);
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('subtotal', 12, 2);    

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_venta');
    }
};
