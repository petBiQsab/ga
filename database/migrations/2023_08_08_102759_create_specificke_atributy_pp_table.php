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
        Schema::create('specificke_atributy_pp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->unsignedBigInteger('id_speci_atribut')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');
            $table->foreign('id_speci_atribut')->references('id')->on('specificke_atributy');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specificke_atributy_pp');
    }
};
