<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',191)->nullable();
            $table->string('phone',191)->nullable();
            $table->string('gender',191)->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('province_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->mediumText('biography')->nullable();
            $table->text('avatar')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();

            //foreign keys:

            $table->foreign('country_id')
			      ->references('id')->on('countries');

            $table->foreign('user_id')
			      ->references('id')->on('users')
				  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_meta');
    }
}
