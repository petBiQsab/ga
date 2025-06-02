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
            $table->unsignedBigInteger('id_muscow')->nullable()->after('id_ryg')->index();

            $table->foreign('id_muscow')->references('id')->on('muscow');

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
