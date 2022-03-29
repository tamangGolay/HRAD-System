<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RoomBed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roomBed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dzongkhag')->references('id')->on('dzongkhags')->nullable();
            $table->foreignId('roomdetails_id')->references('id')->on('guestHouseRoom')->nullable();
            $table->foreignId('guest_house_id')->references('id')->on('guestHouseName')->nullable();
           
            $table->integer('grade')->nullable();

            $table->string('gender')->nullable();
            $table->foreignId('org_unit_id')->references('id')->on('orgUnit')->nullable();
            $table->string('name')->nullable();
            $table->integer('emp_id')->nullable();

            $table->integer('employeeId')->nullable();//addded new field

            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->string('email')->nullable();
            $table->integer('rate')->nullable();
            $table->integer('statusrb')->default(0);



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
        //
    }
}
