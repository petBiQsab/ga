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
        Schema::table('projektove_portfolio', function (Blueprint $table) {
            $table->timestamp('rgp_ready')->nullable()->after('id_reporting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projektove_portfolio', function (Blueprint $table) {
            //
        });
    }
};
