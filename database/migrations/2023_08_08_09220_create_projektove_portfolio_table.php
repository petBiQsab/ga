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
        Schema::create('projektove_portfolio', function (Blueprint $table) {
            $table->id();
            $table->integer('id_original')->index()->nullable();
            $table->integer('id_projekt')->index()->nullable();
            $table->integer('id_parent')->index()->nullable();
            $table->integer('id_child')->index()->nullable();
            $table->string('nazov_projektu')->nullable();
            $table->string('alt_nazov_projektu',1000)->nullable();
            $table->unsignedBigInteger('id_reporting')->index()->nullable();
            $table->unsignedBigInteger('id_planovanie_rozpoctu')->index()->nullable();
            $table->integer('max_rok')->nullable();
            $table->string('created_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_reporting')->references('id')->on('reporting');
            $table->foreign('id_planovanie_rozpoctu')->references('id')->on('planovanie_rozpoctu');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projektove_portfolio');
    }
};
