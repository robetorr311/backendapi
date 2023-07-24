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
        Schema::create('consultorio.citas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_documento');
            $table->bigInteger('id_paciente');
            $table->bigInteger('id_medico');
            $table->bigInteger('id_servicio');
            $table->bigInteger('id_horario');
            $table->bigInteger('id_turno');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultorio.citas');
    }
};
