<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatefamilydetailsmasterTable extends Migration
{
    public function up()
    {
        Schema::create('familydetailsmaster', function (Blueprint $table) {

        $table->Id('familyId');
		$table->Integer('personalNo');  //fk md employee master
        $table->string('relativeName');
        $table->date('dob');
        $table->string('gender');
        $table->string('relation');  //fk to md relation master

		
        });
    }

    public function down()
    {
        Schema::dropIfExists('familydetailsmaster');
    }
}