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
            $table->integer('Size_2XL'); 
            $table->integer('Size_3XL'); 
            $table->integer('Size_4XL'); 
            $table->integer('Size_5XL'); 
            $table->integer('Size_6XL'); 
            $table->integer('shoe_3');
            $table->integer('shoe_4'); 
            $table->integer('shoe_5'); 
            $table->integer('shoe_6'); 
            $table->integer('shoe_7'); 
            $table->integer('shoe_8'); 
            $table->integer('shoe_9'); 
            $table->integer('shoe_10'); 
            $table->integer('shoe_11'); 
            $table->integer('shoe_12'); 
            $table->integer('shoe_13'); 
            $table->integer('shoe_14'); 
            $table->integer('shoe_15');            
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
