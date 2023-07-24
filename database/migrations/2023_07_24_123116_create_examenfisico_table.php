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
        Schema::create('consultorio.examenfisico', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_paciente');
            $table->date('fecha');
            $table->text('sistolica');
            $table->text('diastolica');
            $table->text('pulso');
            $table->text('frecuencia_cardiaca');
            $table->text('frecuencia_respiratoria');
            $table->text('peso');
            $table->text('talla');
            $table->text('temperatura');
            $table->bigInteger('id_electrocardiograma')->nullable();
            $table->bigInteger('id_hematologia')->nullable();
            $table->text('aspecto');
            $table->bigInteger('id_documento');
            $table->bigInteger('id_servicio');
            $table->bigInteger('id_cita');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultorio.examenfisico');
    }
};
