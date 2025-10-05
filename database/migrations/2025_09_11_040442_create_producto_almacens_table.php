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
                // id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
                $table->id();

                // BIGINT UNSIGNED (con índices tipo MUL)
                $table->foreignId('producto_id')
                    ->constrained('producto')   // si tus tablas se llaman exactamente 'producto', 'almacen', 'empresa'
                    ->cascadeOnDelete();        // opcional; quítalo si no quieres FK

                $table->foreignId('almacen_id')
                    ->constrained('almacen')
                    ->cascadeOnDelete();

                $table->foreignId('empresa_id')
                    ->constrained('empresa');

                // lote VARCHAR(100) NULL con índice (MUL)
                $table->string('lote', 100)->nullable()->index();

                // id_lote INT(11) NULL
                $table->integer('id_lote')->nullable();

                // producto_compra_id INT(11) NOT NULL UNIQUE
                $table->integer('producto_compra_id');
                $table->unique('producto_compra_id');

                // stock DECIMAL(12,2) NOT NULL DEFAULT 0.00
                $table->decimal('stock', 12, 2)->default(0.00);

                // estado INT(11) NOT NULL DEFAULT 1
                $table->integer('estado')->default(1);

                // created_at / updated_at -> NULL por defecto
                $table->timestamps();
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
