<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',191)->nullable();
            $table->longText('content')->nullable();
            $table->longText('excerpt')->nullable();
            $table->timestamp('published_at')->nullable();
			$table->unsignedInteger('author_id')->nullable();
			$table->unsignedInteger('post_id')->nullable();
			$table->integer('order')->default(0);
			$table->string('type',191)->default('text');
			$table->text('cover')->nullable();
            $table->string('slug',191)->nullable();
			$table->softDeletes();
            $table->timestamps();

            //foreign keys:
            $table->foreign('author_id')
			      ->references('id')->on('users')
				  ->onDelete('cascade');

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
        Schema::dropIfExists('posts');
    }
}
