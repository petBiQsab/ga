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
        Schema::table('mtl_log', function (Blueprint $table) {
            $table->text('komentar')->nullable()->after('status');
            $table->text('planovane_aktivity_na_najblizsi_mesiac')->nullable()->after('status');
            $table->text('zrealizovane_aktivity')->nullable()->after('status');
            $table->text('rizika_projektu')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtl_log', function (Blueprint $table) {
            //
        });
    }
};
