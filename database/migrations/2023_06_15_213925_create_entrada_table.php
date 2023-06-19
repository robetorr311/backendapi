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
        Schema::create('inventario.entrada', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nroorden', 200);
            $table->string('factura', 200);
            $table->bigInteger('id_articulo');
            $table->float('precio_unitario', 15, 4);
            $table->float('precio_venta', 15, 4);
            $table->bigInteger('cantidad');
            $table->bigInteger('unidades')->nullable();
            $table->bigInteger('id_presentacion');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario.entrada');
    }
};
