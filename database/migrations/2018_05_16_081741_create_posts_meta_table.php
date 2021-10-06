<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',191)->unique();
            $table->mediumText('value')->nullable();
            $table->unsignedInteger('post_id')->nullable();
            $table->timestamps();

            //foreign keys:
            $table->foreign('post_id')
			      ->references('id')->on('posts')
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
        Schema::dropIfExists('posts_meta');
    }
}
