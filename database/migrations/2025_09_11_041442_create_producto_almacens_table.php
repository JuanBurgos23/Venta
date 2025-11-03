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
        
            $table->foreignId('producto_id')->constrained('producto')->cascadeOnDelete();
            $table->foreignId('almacen_id')->constrained('almacen')->cascadeOnDelete();
            $table->foreignId('empresa_id')->constrained('empresa')->cascadeOnDelete();
        
            $table->foreignId('producto_compra_id')->constrained('producto_compra')->cascadeOnDelete();
        
            $table->unsignedBigInteger('id_lote'); // interno
            $table->string('lote', 100)->nullable(); // visible
            $table->decimal('stock', 12, 2)->default(0);
            $table->integer('estado')->default(1);
            $table->timestamps();
        
            // un registro por (producto, almacén, lote interno)
            $table->unique(['producto_id','almacen_id','id_lote'], 'producto_almacen_unq');
            $table->index('lote');
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
