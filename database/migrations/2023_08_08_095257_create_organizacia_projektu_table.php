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
        Schema::create('organizacia_projektu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->string('id_zadavatel_projektu')->nullable()->index();
            $table->string('id_projektovy_garant')->nullable()->index();
           // $table->string('id_utvar_projektoveho_manazera')->nullable()->index();
            $table->string('externi_stakeholderi',700)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');
            $table->foreign('id_zadavatel_projektu')->references('objectguid')->on('groups');
            $table->foreign('id_projektovy_garant')->references('objectguid')->on('users');
          //  $table->foreign('id_utvar_projektoveho_manazera')->references('objectguid')->on('groups');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projektove_organizacia_projektu');
    }
};
