<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationRecipientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_recipient', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipient_id');
            $table->unsignedInteger('notification_id');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            //foreign keys:

            $table->foreign('recipient_id')
			      ->references('id')->on('users')
				  ->onDelete('cascade');

            $table->foreign('notification_id')
			      ->references('id')->on('notifications')
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
        Schema::dropIfExists('notification_recipient');
    }
}
