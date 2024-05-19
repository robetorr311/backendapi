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
        Schema::create('dulcepaladar.pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero', 200);
            $table->date('fecha');
            $table->bigInteger('id_pago');
            $table->bigInteger('id_articulo');
            $table->bigInteger('cantidad');
            $table->float('precio', 15, 4)->comment('precio de venta');
            $table->bigInteger('id_estatus');
            $table->float('total', 15, 4)->comment('cantidad x precio de venta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dulcepaladar.pedidos');
    }
};
