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
        Schema::create('consultorio.antecedentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('diabetes')->nullable();
            $table->integer('dislipidemias')->nullable();
            $table->integer('tabaquismo')->nullable();
            $table->integer('sedentarismo')->nullable();
            $table->integer('obesidad')->nullable();
            $table->integer('diagnosticoeac')->nullable();
            $table->integer('angina')->nullable();
            $table->integer('cf')->nullable();
            $table->integer('im')->nullable();
            $table->integer('angioplastia')->nullable();
            $table->integer('cirugia')->nullable();
            $table->integer('arritmias')->nullable();
            $table->integer('sv')->nullable();
            $table->integer('bloqueoav')->nullable();
            $table->integer('mpd')->nullable();
            $table->integer('acv')->nullable();
            $table->integer('enfcaritidea')->nullable();
            $table->integer('enfperiferica')->nullable();
            $table->integer('cardreumatica')->nullable();
            $table->bigInteger('id_paciente')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultorio.antecedentes');
    }
};
