<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateofficereportingstructuremasterTable extends Migration
{
    public function up()
    {
        Schema::create('officereportingstructuremaster', function (Blueprint $table) {
        $table->id();
		$table->foreignId('officeId')->references('id')->on('users');    //fk office master 
		$table->integer('reportsToOffice'); 
        $table->date('fromDate'); 
        $table->date('endDate');
        $table->tinyInteger('status')->default(0);
		$table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('officereportingstructuremaster');
    }
}