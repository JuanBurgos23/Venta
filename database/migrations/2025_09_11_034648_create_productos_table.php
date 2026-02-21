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
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_empresa')
                  ->constrained('empresa');
            $table->foreignId('unidad_medida_id')
                  ->nullable()
                  ->constrained('unidad_medida');
            $table->foreignId('tipo_producto_id')
                  ->nullable()
                  ->constrained('tipo_producto');
            $table->foreignId('categoria_id')
                  ->nullable()
                  ->constrained('categoria');

            $table->foreignId('subcategoria_id')
                  ->nullable()
                  ->constrained('subcategoria');
            $table->foreignId('tipo_precio_id')
                  ->nullable()
                  ->constrained('tipo_precio');

            // Identificación
            $table->string('codigo', 100); 
            $table->string('nombre', 200);
            $table->string('foto', 200)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('origen', 100)->nullable();
            $table->integer('estado')->nullable()->default(1);
            $table->integer('stock_minimo')->nullable()->default(0);
            $table->decimal('costo', 12, 2)->nullable()->default(0);
            $table->integer('inventariable')->nullable()->default(1);
            $table->decimal('precio', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
