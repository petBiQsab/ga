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
        Schema::table('organizacia_projektu', function (Blueprint $table) {
            $table->string('id_politicky_garant')->nullable()->index();
            $table->string('id_magistratny_garant')->nullable()->index();

            $table->foreign('id_politicky_garant')->references('objectguid')->on('users');
            $table->foreign('id_magistratny_garant')->references('objectguid')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizacia_projektu', function (Blueprint $table) {
            //
        });
    }
};
