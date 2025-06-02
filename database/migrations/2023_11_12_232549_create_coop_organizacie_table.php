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
        Schema::create('coop_organizacie', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->string('id_group')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');
            $table->foreign('id_group')->references('objectguid')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coop_organizacie');
    }
};
