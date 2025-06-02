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

        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('cn')->nullable();
            $table->string('skratka')->nullable();
            $table->string('objectguid')->index()->nullable();
            $table->string('typ')->nullable();
            $table->string('ico')->nullable();
            $table->string('gestor_utvar')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
