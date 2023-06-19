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
        Schema::create('comun.perfil', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_usuario')->index(); 
            $table->string('direccion', 500);
            $table->bigInteger('id_estado')->index();
            $table->bigInteger('id_municipio')->index();
            $table->bigInteger('id_parroquia')->index();
            $table->bigInteger('id_localidad')->index();
            $table->string('twitter', 200)->nullable();
            $table->string('instagram', 200)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->string('cedula', 10)->unique()->index();
            $table->bigInteger('id_tipousuario');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comun.perfil');
    }
};
