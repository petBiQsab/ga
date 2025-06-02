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
        Schema::create('projektove_portfolio_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->string('ciel_projektu',1500)->nullable();
            $table->string('meratelny_vystupovy_ukazovatel',1000)->nullable();
            $table->unsignedBigInteger('id_kategoria_projektu')->nullable();
            $table->unsignedBigInteger('id_stav_projektu')->nullable();
            $table->unsignedBigInteger('id_faza_projektu')->nullable();
            $table->date('datum_zacatia_projektu')->nullable();
            $table->date('datum_konca_projektu')->nullable();
            $table->string('rizika_projektu',2000)->nullable();
            $table->string('zrealizovane_aktivity',2000)->nullable();
            $table->string('planovane_aktivity_na_najblizsi_mesiac',2000)->nullable();
            $table->double('najaktualnejsia_cena_projektu_vrat_DPH',16,2)->nullable();
            $table->double('najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH',16,2)->nullable();
            $table->string('poznamky',2000)->nullable();
            $table->string('poznamky_pm',2000)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');
            $table->foreign('id_kategoria_projektu')->references('id')->on('kategoria');
            $table->foreign('id_stav_projektu')->references('id')->on('stav_projektu');
            $table->foreign('id_faza_projektu')->references('id')->on('faza_projektu');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projektove_portfolio_details');
    }
};
