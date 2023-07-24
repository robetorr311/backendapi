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
        Schema::create('consultorio.documento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('numero');
            $table->bigInteger('id_origen');
            $table->bigInteger('id_destino');
            $table->bigInteger('id_tipodocumento');
            $table->bigInteger('id_estatus');
            $table->date('fecha');
            $table->bigInteger('id_serviciosmedico');
            $table->bigInteger('id_usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultorio.documento');
    }
};
