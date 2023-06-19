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
        Schema::create('inventario.movimiento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_tipomovimiento');
            $table->bigInteger('id_articulo');
            $table->bigInteger('cantidad');
            $table->float('valor', 15, 4);
            $table->bigInteger('id_entrada');
            $table->bigInteger('id_salida');
            $table->date('fecha');
            $table->bigInteger('id_usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario.movimiento');
    }
};
