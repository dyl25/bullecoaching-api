<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoAndExplenationColumnToExercises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->integer('begin_image_id')->unsigned()->nullable();
            $table->foreign('begin_image_id')->references('id')->on('images')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('end_image_id')->unsigned()->nullable();
            $table->foreign('end_image_id')->references('id')->on('images')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('video_id')->unsigned()->nullable();
            $table->foreign('video_id')->references('id')->on('videos')->onUpdate('cascade')->onDelete('cascade');
            $table->text('explenation')->nullable();
            $table->string('display_mode', 10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropForeign('exercises_video_id_foreign');
            $table->dropForeign('exercises_begin_image_id_foreign');
            $table->dropForeign('exercises_end_image_id_foreign');
            $table->dropColumn('video_id');
            $table->dropColumn('explenation');
        });
    }
}
