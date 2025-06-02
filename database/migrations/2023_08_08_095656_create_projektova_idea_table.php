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
        Schema::create('projektova_idea', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pp')->nullable()->index();

            $table->double('celkom_bv_a_kv_vrat_dph',16,2)->nullable();
            $table->double('rocne_prevadzkove_naklady_projektu_vrat_dph',16,2)->nullable();
            $table->double('idea_bezne_ocakavane_rocne_naklady_projektu_s_dph',16,2)->nullable();
            $table->double('idea_kapitalove_ocakavane_rocne_naklady_projektu_s_dph',16,2)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pp')->references('id')->on('projektove_portfolio');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projektova_idea');
    }
};
