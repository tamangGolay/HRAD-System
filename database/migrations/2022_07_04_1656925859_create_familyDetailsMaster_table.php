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
		$table->foreignId('personalNo')->references('id')->on('users');  //fk md employee master
        $table->string('relativeName',50);
        $table->bigInteger('cidNo');
		$table->string('cidOther',30)->nullable();
        $table->date('dob');
        $table->string('gender',10);
        $table->foreignId('relation')->references('id')->on('relationmaster');  //fk to md relation master
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
		
        });
    }

    public function down()
    {
        Schema::dropIfExists('familydetailsmaster');
    }
}