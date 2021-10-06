<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name',191)->nullable();
			$table->string('email',191)->nullable();
			$table->longText('comment');
			$table->unsignedInteger('comment_id')->nullable();
			$table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('commentable_id');
            $table->string('commentable_type',191);
			$table->softDeletes();
			$table->timestamps();

            //foreign keys:

            $table->foreign('comment_id')
			      ->references('id')->on('comments')
				  ->onDelete('cascade');

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
        Schema::dropIfExists('comments');
    }
}
