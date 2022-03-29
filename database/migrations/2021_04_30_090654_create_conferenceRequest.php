<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferenceRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferenceRequest', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
             $table->string('name'); 
            // $table->string('designation')->nullable();
            $table->string('contact_number')->nullable(); 
            $table->foreignId('org_unit_id')->references('id')->on('orgUnit')->nullable();
            $table->string('meeting_name');
            $table->foreignId('no_of_people')->nullable(); 
            $table->foreignId('conference_id')->references('id')->on('conference')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');            
            $table->integer('status')->default(0);
            $table->string('reason')->nullable();
            $table->string('default')->nullable();

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
        Schema::dropIfExists('conferenceRequest');
    }
}
