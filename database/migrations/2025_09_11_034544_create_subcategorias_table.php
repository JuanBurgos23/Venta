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
        Schema::create('subcategoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')
                ->constrained('categoria')
                ->onDelete('cascade');

            $table->string('nombre', 150);
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
        Schema::dropIfExists('subcategoria');
    }
};
