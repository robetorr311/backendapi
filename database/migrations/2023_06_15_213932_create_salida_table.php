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
        Schema::create('inventario.salida', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nroorden', 200);
            $table->string('referencia', 200);
            $table->bigInteger('id_articulo');
            $table->float('precio_venta', 15, 4);
            $table->bigInteger('cantidad');
            $table->bigInteger('id_venta');
            $table->bigInteger('id_usuario');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario.salida');
    }
};
