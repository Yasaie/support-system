<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email',191)->unique()->nullable()->length;
            $table->string('mobile',191)->unique()->nullable();
			$table->boolean('is_owner')->default(false);
			$table->boolean('is_admin')->default(false);
			$table->timestamp('locked_at')->nullable();
            $table->timestamp('verified_at')->nullable();
			$table->timestamp('email_verified_at')->nullable();
			$table->timestamp('mobile_verified_at')->nullable();
			$table->string('email_token',191)->nullable();
			$table->string('mobile_token',191)->nullable();
			$table->string('password',191);
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
