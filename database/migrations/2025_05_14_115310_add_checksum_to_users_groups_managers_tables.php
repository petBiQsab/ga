<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('users', function (Blueprint $table) {
            $table->string('checksum', 100)->nullable();
        });
        DB::statement(
            "UPDATE users set checksum = SHA2(CONCAT(IFNULL(name, ''), '|', IFNULL(sn, ''), '|', IFNULL(givenName, ''), '|', email, '|', IFNULL(objectguid, ''), '|', IFNULL(department, ''), '|', IFNULL(jobTitle, ''), '|', IFNULL(activeUser, '')), 256)"
        );
        Schema::table('users', function (Blueprint $table) {
            $table->string('objectguid')->nullable(false)->unique('users_objectguid_unique')->change();
            $table->string('checksum')->nullable(false)->change();
        });


        Schema::table('groups', function (Blueprint $table) {
            $table->string('checksum', 100)->nullable();
        });
        DB::statement(
            "UPDATE groups set checksum = SHA2(CONCAT(IFNULL(cn, ''), '|', IFNULL(skratka, ''), IFNULL(objectguid, ''), '|', IFNULL(typ, ''), '|', IFNULL(ico, '')), 256)"
        );
        Schema::table('groups', function (Blueprint $table) {
            $table->string('objectguid')->nullable(false)->unique('groups_objectguid_unique')->change();
            $table->string('checksum')->nullable(false)->change();
        });


        Schema::table('user_groups', function (Blueprint $table) {
            $table->foreign('user_id', 'user_groups_user_id_foreign')->references('objectguid')->on('users');
            $table->foreign('group_id', 'user_groups_group_id_foreign')->references('objectguid')->on('groups');
            $table->foreign('group', 'user_groups_group_foreign')->references('objectguid')->on('groups');
        });


        Schema::table('managers', function (Blueprint $table) {
            $table->foreign('id_user', 'managers_user_id_foreign')->references('objectguid')->on('users');
            $table->foreign('id_group', 'managers_group_id_foreign')->references('objectguid')->on('groups');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('checksum');
            $table->dropUnique('users_objectguid_unique');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('checksum');
            $table->dropUnique('groups_objectguid_unique');
        });

        Schema::table('user_groups', function (Blueprint $table) {
            $table->dropForeign('user_groups_user_id_foreign');
            $table->dropForeign('user_groups_group_foreign');
            $table->dropForeign('user_groups_group_id_foreign');
        });

        Schema::table('managers', function (Blueprint $table) {
            $table->dropForeign('managers_user_id_foreign');
            $table->dropForeign('managers_group_id_foreign');
        });

    }
};
