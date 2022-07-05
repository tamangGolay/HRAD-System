<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationmaterTable extends Migration
{
    public function up()
    {
        Schema::create('qualificationmater', function (Blueprint $table) {
         $table->integer('personalNo'); 
		$table->integer('qualificationId');
		$table->string('qualificationShortname');
        $table->string('qualificationLongname');
		$table->integer('qualificationLevel');
		$table->integer('qualificationSequence');
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('qualificationmater');
    }
}