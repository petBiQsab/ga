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
        Schema::create('kvalifikovany_odhad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->double('kvalifikovany_odhad_ceny_projektu',16,2)->nullable();
            $table->double('kvalifikovany_odhad_rocnych_prevadzkovych_nakladov_vrat_dph',16,2)->nullable();
            $table->string('zdroj_info_kvalif_odhad')->nullable();
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
        Schema::dropIfExists('kvalifikovany_odhad');
    }
};
