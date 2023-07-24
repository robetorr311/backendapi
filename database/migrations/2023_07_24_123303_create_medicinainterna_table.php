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
        Schema::create('consultorio.medicinainterna', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_documento');
            $table->date('fecha');
            $table->bigInteger('id_paciente');
            $table->bigInteger('id_medico');
            $table->bigInteger('id_examenfisico');
            $table->text('motivo')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('enfermedad')->nullable();
            $table->text('tratamiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultorio.medicinainterna');
    }
};
