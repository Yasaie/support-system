<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('department_id');
            $table->boolean('is_leader')->default(false);
            $table->timestamps();

            //foreign keys:

            $table->foreign('user_id')
			      ->references('id')->on('users')
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
        Schema::dropIfExists('departments_users');
    }
}
