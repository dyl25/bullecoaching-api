<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gender_id')->unsigned();
            $table->foreign('gender_id')->references('id')->on('genders')->onUpdate('cascade');
            $table->bigInteger('managed_by_id')->unsigned()->nullable();
            $table->foreign('managed_by_id')->references('id')->on('users')->onUpdate('cascade');
            $table->string('name');
            $table->string('firstname');
            $table->dateTime('birthdate')->useCurrent();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('accepted')->nullable()->default(null);
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
        Schema::dropIfExists('demands');
    }
}
