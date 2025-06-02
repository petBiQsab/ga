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
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable()->index();
            $table->string('group')->nullable()->index();
            $table->string('group_id')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('objectguid')->on('users');
            $table->foreign('group')->references('objectguid')->on('groups');
            $table->foreign('group_id')->references('objectguid')->on('groups');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_groups');
    }
};
