<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('ticket_id')->nullable();
            $table->string('subject',191)->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->string('status',191)->nullable();
            $table->string('priority',191)->nullable();
            $table->mediumText('content')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->string('access_key',191)->unique()->nullable();
            $table->softDeletes();
            $table->timestamps();

            //foreign keys:

            $table->foreign('user_id')
			      ->references('id')->on('users')
				  ->onDelete('cascade');

            $table->foreign('ticket_id')
			      ->references('id')->on('tickets')
				  ->onDelete('cascade');

            $table->foreign('department_id')
			      ->references('id')->on('departments')
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
        Schema::dropIfExists('tickets');
    }
}
