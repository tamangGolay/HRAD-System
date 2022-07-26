<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetransfermasterTable extends Migration
{
    public function up()
    {
        Schema::create('transfermaster', function (Blueprint $table) {
        $table->integer('personalNo')->references('id')->on('users');   //fk md employee master
		$table->date('transferDate');
        $table->integer('transferFrom')->references('id')->on('officemaster'); //fk md officeMaster
        $table->string('transferTo');
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();	
        });
    }

    public function down()
    {
        Schema::dropIfExists('transfermaster');
    }
}