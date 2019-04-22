<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeIdColumnsToStringType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_actions', function (Blueprint $table) {
            $table->string('module_id', 50)->change();
            $table->string('created_by_user', 50)->change();
        });

        Schema::table('car_comments', function (Blueprint $table) {
            $table->string('module_id', 50)->change();
            $table->string('user_id', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_actions', function (Blueprint $table) {
            $table->integer('module_id')->change();
            $table->integer('created_by_user')->change();
        });

        Schema::table('car_comments', function (Blueprint $table) {
            $table->integer('module_id')->change();
            $table->integer('user_id')->change();
        });
    }
}
