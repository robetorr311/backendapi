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
        Schema::create('inventario.articulo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 200);
            $table->string('descripcion', 500);
            $table->float('precio_unitario', 15, 4)->comment('precio de compra o de entrada al inventario');
            $table->float('precio_venta', 15, 4)->comment('precio de venta fijado por el comerciante');
            $table->bigInteger('id_imagen');
            $table->string('codigo', 200)->comment('codigo de barra');
            $table->bigInteger('id_usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario.articulo');
    }
};
