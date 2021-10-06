<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',191)->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('extension',191)->nullable();
            $table->string('mime',191)->nullable();
            $table->string('real_name',191)->nullable();
            $table->string('upload_path',191)->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamp('complete_at')->nullable();
            $table->timestamp('resume_at')->nullable();
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
        Schema::dropIfExists('medias');
    }
}
