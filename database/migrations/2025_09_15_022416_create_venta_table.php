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

            // Cabecera / referencias
            $table->string('codigo', 50)->unique(); // ej. V-00001
            $table->dateTime('fecha'); // fecha y hora de la venta
            $table->foreignId('cliente_id')->nullable()->constrained('cliente')->onDelete('set null');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade'); // usuario que registró la venta
            $table->foreignId('empresa_id')->nullable()->constrained('empresa')->onDelete('cascade');
            $table->foreignId('almacen_id')->nullable()->constrained('almacen')->onDelete('set null');

            // Totales
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // Pago y estado
            $table->enum('forma_pago', ['Efectivo', 'Tarjeta', 'Qr'])->nullable();
            $table->enum('estado', ['Registrado', 'Pagado', 'Pendiente', 'Anulado'])->default('Registrado');

            // Observaciones y timestamps
            $table->text('observaciones')->nullable();
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
