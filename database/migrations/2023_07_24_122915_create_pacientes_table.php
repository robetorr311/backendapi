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
        Schema::create('consultorio.pacientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('cedula')->unique()->index();
            $table->text('nombre');
            $table->date('fechadenacimiento');
            $table->text('sexo');
            $table->text('email');
            $table->text('telefono_domicilio');
            $table->text('telefono_movil');
            $table->text('direccion');
            $table->bigInteger('id_estado')->index();
            $table->bigInteger('id_municipio')->index();
            $table->bigInteger('id_parroquia')->index();
            $table->bigInteger('id_localidad')->index();
            $table->bigInteger('id_herencia');
            $table->bigInteger('id_profesion');
            $table->bigInteger('id_estadocivil');
            $table->bigInteger('id_estatus');
            $table->bigInteger('id_antecedentes');
            $table->bigInteger('id_usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultorio.pacientes');
    }
};
