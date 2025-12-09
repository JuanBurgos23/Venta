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
        Schema::create('empresa_config', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_empresa')
                  ->constrained('empresa')
                  ->onDelete('cascade');

            $table->json('configuraciones')->nullable();

            $table->timestamps();
            $table->unique('id_empresa', 'empresa_config_unique_empresa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_config');
    }
};
