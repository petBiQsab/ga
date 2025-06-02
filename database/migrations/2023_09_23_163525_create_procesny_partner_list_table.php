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
        Schema::create('procesny_partner_list', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_user')->references('objectguid')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procesny_partner_list');
    }
};
