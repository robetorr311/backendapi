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
        Schema::create('ventas.pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('referencia', 200);
            $table->date('fecha');
            $table->bigInteger('id_orden');
            $table->bigInteger('id_usuario');
            $table->float('monto', 15, 4);
            $table->bigInteger('id_estatus');
            $table->bigInteger('id_metodo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas.pagos');
    }
};
