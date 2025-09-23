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
        Schema::create('compra', function (Blueprint $table) {
            $table->id();
            // Dueño del documento
            $table->foreignId('id_empresa')
                  ->constrained('empresa');

            $table->foreignId('sucursal_id')
                  ->nullable()
                  ->constrained('sucursal');

            $table->foreignId('almacen_id')
                  ->constrained('almacen');
            $table->foreignId('proveedor_id')
                  ->constrained('proveedor');

            $table->date('fecha_ingreso')->nullable();  
            $table->string('tipo', 30)->nullable(); 
            $table->decimal('subtotal', 18, 6)->default(0);
            $table->decimal('descuento', 18, 6)->default(0);
            $table->decimal('total', 18, 6)->default(0);

            $table->integer('estado')->default(1); 
            $table->string('observacion', 255)->nullable();
            $table->string('recepcion', 100)->nullable();
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra');
    }
};
