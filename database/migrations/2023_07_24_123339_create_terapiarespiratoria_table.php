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
        Schema::create('consultorio.terapiarespiratoria', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_documento');
            $table->date('fecha');
            $table->bigInteger('id_paciente');
            $table->bigInteger('id_medico');
            $table->bigInteger('id_examenfisico');
            $table->text('diagnostico')->nullable();
            $table->text('fisio_terapia_torax')->nullable();
            $table->text('espirometria_incentiva')->nullable();
            $table->text('inhalo_terapia')->nullable();
            $table->text('tecnicas_relajacion')->nullable();
            $table->text('entrenamiento_fisico')->nullable();
            $table->text('sugerencias')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultorio.terapiarespiratoria');
    }
};
