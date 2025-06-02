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
        Schema::create('prioritne_oblasti_pp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();
            $table->unsignedBigInteger('id_prioritne_oblasti')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');
            $table->foreign('id_prioritne_oblasti')->references('id')->on('prioritne_oblasti');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prioritne_oblasti');
    }
};
