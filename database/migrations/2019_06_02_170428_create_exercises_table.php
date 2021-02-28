<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('difficulty_id')->unsigned();
            $table->foreign('difficulty_id')->references('id')->on('difficulties')->onUpdate('cascade');
            $table->bigInteger('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('users')->onUpdate('cascade');
            $table->string('name');
            $table->string('display_mode', 10);
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
        Schema::dropIfExists('exercises');
    }
}
