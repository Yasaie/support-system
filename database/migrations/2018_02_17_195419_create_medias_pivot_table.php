<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('media_id');
            $table->unsignedInteger('pivot_id');
            $table->string('pivot_type',191);
            $table->timestamps();

            //foreign keys:

            $table->foreign('media_id')
			      ->references('id')->on('medias')
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
        Schema::dropIfExists('medias_pivot');
    }
}
