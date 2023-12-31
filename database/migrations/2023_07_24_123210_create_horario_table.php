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
        Schema::create('consultorio.horarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('descripcion');
            $table->bigInteger('id_turno');
            $table->text('inicio');
            $table->text('fin');
            $table->integer('cupos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultorio.horarios');
    }
};
