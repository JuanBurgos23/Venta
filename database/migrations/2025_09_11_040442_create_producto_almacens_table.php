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
                $table->foreignId('producto_id')
                    ->constrained('producto')
                    ->cascadeOnDelete();

                $table->foreignId('almacen_id')
                    ->constrained('almacen')
                    ->cascadeOnDelete();

                $table->foreignId('empresa_id')
                    ->constrained('empresa');
                $table->string('lote');
                $table->integer('producto_compra_id');
    
            // Si manejas lotes ligados a una compra, usa unique de 3 columnas:
                $table->unique(['producto_id', 'almacen_id']);
                $table->decimal('stock', 12, 2)->default(0);
                $table->integer('estado')->default(1); // 1: activo, 0: inactivo
                $table->timestamps();

                $table->unique(['producto_compra_id']);
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
