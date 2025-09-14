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
        Schema::create('tipo_precio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_empresa')
            ->constrained('empresa');
        
            $table->string('nombre', 100);
            $table->string('descripcion', 200)->nullable();
            $table->integer('estado')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_precio');
    }
};
