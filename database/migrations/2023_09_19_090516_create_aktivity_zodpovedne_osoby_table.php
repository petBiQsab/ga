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
        Schema::create('aktivity_zodpovedne_osoby', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aktivity_pp')->nullable()->index();
            $table->string('id_user')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_aktivity_pp')->references('id')->on('aktivity_pp');
            $table->foreign('id_user')->references('objectguid')->on('users');

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivity_zodpovedne_osoby');
    }
};
