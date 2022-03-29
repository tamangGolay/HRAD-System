<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conference', function (Blueprint $table) {
            $table->id();
            $table->string('Conference_Name',30);
            $table->integer('capacity');
            $table->string('location');
            $table->foreignId('range_id')->references('id')->on('rangeofpeople');
            $table->integer('status_c')->default(0);
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
        Schema::dropIfExists('conference');
    }
}
