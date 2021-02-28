<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_type_id')->unsigned();
            $table->foreign('event_type_id')->references('id')->on('events_type')->onUpdate('cascade');
            $table->bigInteger('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users')->onUpdate('cascade');
            $table->integer('content_id')->unsigned()->nullable();
            $table->foreign('content_id')->references('id')->on('programs')->onUpdate('cascade');
            $table->string('name');
            $table->datetime('from');
            $table->datetime('to')->nullable();
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
        Schema::dropIfExists('events');
    }
}
