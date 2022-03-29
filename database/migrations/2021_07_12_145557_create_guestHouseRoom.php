<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestHouseRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guestHouseRoom', function (Blueprint $table) {
            $table->id();
            $table->string('room_no'); 
            $table->integer('bed_no')->nullable();
            $table->foreignId('guest_house_id')->references('id')->on('guestHouseName');
            $table->foreignId('dzo_id')->references('id')->on('dzongkhags');
             $table->integer('status')->default(0);

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
        Schema::dropIfExists('guestHouseRoom');
    }
}
