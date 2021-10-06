<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('ip',191)->nullable();
            $table->string('referrer',191)->nullable();
            $table->string('user_agent',191)->nullable();
            $table->string('likable_type',191);
            $table->unsignedInteger('likable_id');
            $table->timestamps();

            //foreign keys:

            $table->foreign('user_id')
			      ->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
