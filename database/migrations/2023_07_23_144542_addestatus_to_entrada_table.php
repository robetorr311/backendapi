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
        Schema::table('inventario.entrada', function (Blueprint $table) {
            $table->bigInteger('id_estatus')->default(1)->comment('1=Active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventario.entrada', function (Blueprint $table) {
            //
        });
    }
};
