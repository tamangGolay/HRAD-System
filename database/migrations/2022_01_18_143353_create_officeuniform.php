<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeuniform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officeuniform', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_unit_id')->references('id')->on('orgUnit')->nullable();
            $table->integer('uniform_id'); 
            $table->integer('S'); 
            $table->integer('M'); 
            $table->integer('L'); 
            $table->integer('XL'); 
            $table->integer('2XL'); 
            $table->integer('3XL'); 
            $table->integer('4XL'); 
            $table->integer('5XL'); 
            $table->integer('6XL'); 
            $table->foreignId('dzongkhag')->references('id')->on('dzongkhags')->nullable();
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
        Schema::dropIfExists('officeuniform');
    }
}
