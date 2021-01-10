<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserAndTitleColumnsToThingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('things', function (Blueprint $table) {
            $table->string('title')->default('');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('things', function (Blueprint $table) {
            $table->dropColumn('title');
            // might be broken, cba to fix (not supported in SQLite):
            $table->dropIndex(['user_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
