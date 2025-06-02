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
        Schema::create('aktivity', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('id_kategoria')->nullable()->index();
            $table->string('flag')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_kategoria')->references('id')->on('aktivita_kategoria');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivity');
    }
};
