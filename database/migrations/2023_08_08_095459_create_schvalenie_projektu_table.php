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
        Schema::create('schvalenie_projektu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->date('datum_schvalenia_ID')->nullable();
            $table->unsignedBigInteger('id_schvalenie_pi_na_pg')->nullable()->index();
            $table->date('datum_schvalenia_pi_na_pg')->nullable();
            $table->string('hyperlink_na_pi',1000)->nullable();
            $table->string('pripomienky_k_pi',350)->nullable();
            $table->unsignedBigInteger('id_schvalenie_pz_na_pg')->nullable()->index();
            $table->date('datum_schvalenia_pz_na_pg')->nullable();
            $table->string('hyperlink_na_pz',1000)->nullable();
            $table->string('pripomienky_k_pz',350)->nullable();
            $table->date('datum_schvalenia_projektu_ppp')->nullable();
            $table->date('datum_schvalenia_projektu_msz')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');
            $table->foreign('id_schvalenie_pi_na_pg')->references('id')->on('akceptacia');
            $table->foreign('id_schvalenie_pz_na_pg')->references('id')->on('akceptacia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schvalenie_projektu');
    }
};
