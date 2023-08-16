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
        Schema::create('comun.opinion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nombre');
            $table->text('email');
            $table->text('mensaje');
            $table->bigInteger('id_post');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comun.opinion');
    }
};
