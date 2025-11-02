<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
      Schema::create('detalle_venta_lote', function (Blueprint $t) {
        $t->id();
        $t->foreignId('detalle_venta_id')->constrained('detalle_venta')->cascadeOnDelete();
        $t->foreignId('producto_id')->constrained('producto');
        $t->foreignId('producto_compra_id')->nullable()->constrained('producto_compra'); // de dónde provino el lote
        $t->foreignId('producto_almacen_id')->nullable()->constrained('producto_almacen'); // lote físico
        $t->decimal('cantidad', 14, 4);
        $t->decimal('costo_unitario', 14, 4); // el costo a reconocer (congelado)
        $t->decimal('costo_total', 14, 4);
        $t->timestamps();
      });
    }
    public function down(): void {
      Schema::dropIfExists('detalle_venta_lote');
    }
  };
