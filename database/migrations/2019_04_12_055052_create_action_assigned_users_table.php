<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionAssignedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_action_assigned_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('action_id');
            $table->integer('user_id');
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('mandatory')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_action_assigned_users');
    }
}
