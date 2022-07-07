<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatefamilydetailsmasterTable extends Migration
{
    public function up()
    {
        Schema::create('familydetailsmaster', function (Blueprint $table) {

        $table->id();
		$table->Integer('personalNo')->references('id')->on('employeemaster');  //fk md employee master
        $table->string('relativeName');
        $table->date('dob');
        $table->string('gender');
        $table->string('relation')->references('id')->on('relationmaster');  //fk to md relation master
        $table->integer('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
		
        });
    }

    public function down()
    {
        Schema::dropIfExists('familydetailsmaster');
    }
}