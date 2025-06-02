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
        Schema::table('projektove_portfolio_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ryg')->nullable()->after('najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH')->index();

            $table->foreign('id_ryg')->references('id')->on('ryg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projektove_portfolio_details', function (Blueprint $table) {
            //
        });
    }
};
