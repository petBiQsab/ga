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
        Schema::create('aktivity_pp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->unsignedBigInteger('id_aktivita')->nullable()->index();
            $table->string('vlastna_aktivita')->nullable();
            $table->unsignedBigInteger('id_kategoria')->nullable()->index();
            $table->date('zaciatok_aktivity')->nullable();
            $table->date('skutocny_zaciatok_aktivity')->nullable();
            $table->date('koniec_aktivity')->nullable();
            $table->date('skutocny_koniec_aktivity')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');
            $table->foreign('id_aktivita')->references('id')->on('aktivity');
            $table->foreign('id_kategoria')->references('id')->on('aktivita_kategoria');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivity_pp');
    }
};
