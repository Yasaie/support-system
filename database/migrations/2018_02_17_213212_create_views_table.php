<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('ip',191)->nullable();
            $table->text('referrer')->nullable();
            $table->text('url')->nullable();
            $table->text('agent')->nullable();
            $table->string('browser',191)->nullable();
            $table->string('os',191)->nullable();
            $table->string('continent',191)->nullable();
            $table->string('country',191)->nullable();
            $table->string('country_shortname',191)->nullable();
            $table->string('city',191)->nullable();
            $table->string('latitude',191)->nullable();
            $table->string('longitude',191)->nullable();
            $table->string('viewable_type',191)->nullable();
            $table->unsignedInteger('viewable_id')->nullable();
            $table->timestamps();

            //foreign keys:

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
        Schema::dropIfExists('views');
    }
}
