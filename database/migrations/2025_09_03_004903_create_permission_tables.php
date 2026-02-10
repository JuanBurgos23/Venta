<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =========================
        // 1) CATÁLOGO GLOBAL
        // =========================
        Schema::create('app_modulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 80)->unique();
            $table->string('icono', 80)->nullable();
            $table->integer('orden')->default(0);
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();
        });

        Schema::create('app_pantallas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('modulo_id')->nullable();
            $table->foreign('modulo_id')->references('id')->on('app_modulos')->onDelete('set null');

            $table->string('nombre', 120);
            $table->string('route_name', 190)->unique(); // ej: ventas.index
            $table->string('uri', 190)->nullable();      // ej: /venta
            $table->integer('orden')->default(0);
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();

            $table->index(['modulo_id', 'estado']);
        });

        // (Opcional) si vas a controlar acciones por pantalla:
        Schema::create('app_acciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo', 40)->unique(); // view/create/edit/delete...
            $table->string('nombre', 80);
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();
        });

        Schema::create('app_pantalla_accion', function (Blueprint $table) {
            $table->unsignedBigInteger('pantalla_id');
            $table->unsignedBigInteger('accion_id');

            $table->foreign('pantalla_id')->references('id')->on('app_pantallas')->onDelete('cascade');
            $table->foreign('accion_id')->references('id')->on('app_acciones')->onDelete('cascade');

            $table->primary(['pantalla_id', 'accion_id']);
        });

        // =========================
        // 2) SEGURIDAD MULTIEMPRESA (RBAC propio)
        // =========================
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('empresa_id')->constrained('empresa')->cascadeOnDelete();
            $table->string('nombre', 80);
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();

            $table->unique(['empresa_id','nombre']);
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->foreignId('empresa_id')->constrained('empresa')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();

            $table->primary(['empresa_id','user_id','role_id']);
        });

        Schema::create('role_pantalla', function (Blueprint $table) {
            $table->foreignId('empresa_id')->constrained('empresa')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('pantalla_id')->constrained('app_pantallas')->cascadeOnDelete();

            $table->primary(['empresa_id','role_id','pantalla_id']);
        });
    }

    public function down(): void
    {
        // 1) Seguridad
        Schema::dropIfExists('role_pantalla');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('roles');

        // 2) Catálogo
        Schema::dropIfExists('app_pantalla_accion');
        Schema::dropIfExists('app_acciones');
        Schema::dropIfExists('app_pantallas');
        Schema::dropIfExists('app_modulos');
    }
};
