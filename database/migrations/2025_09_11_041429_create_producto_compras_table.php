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
        Schema::create('producto_compra', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED
            $table->foreignId('producto_id')->constrained('producto')->cascadeOnDelete();
            $table->foreignId('compra_id')->constrained('compra')->cascadeOnDelete();
            $table->foreignId('empresa_id')->constrained('empresa')->cascadeOnDelete();
        
            $table->string('lote', 100)->nullable();
            $table->unsignedBigInteger('id_lote')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->decimal('cantidad', 12, 2)->default(0);
            $table->decimal('costo_unitario', 12, 2)->default(0);
            $table->decimal('costo_total', 12, 2)->nullable();
            $table->timestamps();
        
            // único por producto+compra+lote (o id_lote si lo usas)
            $table->unique(['producto_id','compra_id','lote'], 'producto_compra_unq_prod_comp_lote');
            $table->index('lote');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_compra');
    }
};
