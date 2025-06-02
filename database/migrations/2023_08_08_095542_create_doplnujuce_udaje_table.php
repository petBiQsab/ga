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
        Schema::create('doplnujuce_udaje', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->unsignedBigInteger('id_externe_financovanie')->nullable()->index();
            $table->string('zdroj_externeho_financovania')->nullable();
            $table->double('suma_externeho_financovania',16,2)->nullable();
            $table->double('podiel_externeho_financovania_z_celkovej_ceny',7,2)->nullable();
            $table->unsignedBigInteger('id_priorita')->nullable()->index();
            $table->unsignedBigInteger('id_priorita_new')->nullable()->index();
            $table->unsignedBigInteger('id_verejna_praca')->nullable()->index();
            $table->string('hyperlink_na_ulozisko_projektu',1000)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');
            $table->foreign('id_externe_financovanie')->references('id')->on('externe_financovanie');
            $table->foreign('id_priorita')->references('id')->on('politicka_priorita');
            $table->foreign('id_priorita_new')->references('id')->on('priorita');
            $table->foreign('id_verejna_praca')->references('id')->on('verejna_praca');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doplnujuce_udaje');
    }
};
