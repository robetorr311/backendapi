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
        Schema::create('comun.users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 200); 
            $table->string('login', 10)->unique()->index();
            $table->string('clave');
            $table->string('email', 200)->unique()->index();
            $table->string('telefono', 200)->nullable();
            $table->string('token', 200)->nullable();
            $table->string('codigo', 6)->nullable();
            $table->boolean('estatus')->default(false)->comment('True=active / False=inactive');
            $table->boolean('email_verified')->default(false)->comment('True=yes / False=no');
            $table->boolean('telefono_verified')->default(false)->comment('True=yes / False=no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comun.users');
    }
};
