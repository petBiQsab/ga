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
        Schema::create('export_dataset', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->integer('week_number')->nullable();
            $table->string('status',10)->nullable();
            $table->text('rizika_projektu')->nullable();
            $table->text('zrealizovane_aktivity')->nullable();
            $table->text('planovane_aktivity_na_najblizsi_mesiac')->nullable();
            $table->text('komentar')->nullable();
            $table->date('datum_zacatia_projektu')->nullable();
            $table->date('datum_konca_projektu')->nullable();
            $table->double('najaktualnejsia_cena_projektu_vrat_DPH',16,2)->nullable();
            $table->double('najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH',16,2)->nullable();
            $table->double('suma_externeho_financovania',16,2)->nullable();
            $table->string('zdroj_externeho_financovania')->nullable();
            $table->string('ryg')->nullable();
            $table->string('muscow')->nullable();
            $table->string('faza_projektu')->nullable();
            $table->string('stav_projektu')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('export_dataset');
    }
};
