<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projektove_portfolio_details', function (Blueprint $table) {
            $table->renameColumn(
                'planovane_aktivity_na_najblizsi_mesiac',
                'planovane_aktivity_na_najblizsi_tyzden'
            );
        });
    }

    public function down(): void
    {
        Schema::table('projektove_portfolio_details', function (Blueprint $table) {
            $table->renameColumn(
                'planovane_aktivity_na_najblizsi_tyzden',
                'planovane_aktivity_na_najblizsi_mesiac'
            );
        });
    }
};
