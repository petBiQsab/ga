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
        Schema::create('mestska_cast_pp', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->unsignedBigInteger('id_mc')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');
            $table->foreign('id_mc')->references('id')->on('mestska_cast');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mestska_cast_pp');
    }
};
