<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_actions', function (Blueprint $table) {
            $table->string('uuid')->unique();
            $table->increments('id');
            $table->nullableMorphs('module');
            $table->integer('created_by_user')->nullable();
            $table->text('action')->nullable();
            $table->string('action_identifier')->nullable();
            $table->string('status')->nullable();
            $table->boolean('needs_review')->nullable()->default(false);
            $table->string('rule')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('car_actions');
    }
}
