<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisoUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permiso_user_permissions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable();
            $table->string('of_type')->nullable();
            $table->integer('of_id')->nullable();
            $table->integer('entity_id')->nullable();
            $table->text('child_permissions')->nullable();

            $table->text('meta')->nullable();

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
        Schema::dropIfExists('permiso_user_permissions');
    }
}
