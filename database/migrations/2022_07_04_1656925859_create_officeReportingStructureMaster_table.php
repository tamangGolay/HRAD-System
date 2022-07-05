<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateofficereportingstructuremasterTable extends Migration
{
    public function up()
    {
        Schema::create('officereportingstructuremaster', function (Blueprint $table) {

		$table->integer('officeId')->references('id')->on('officemaster');    //fk office master 
		$table->integer('reportsToOffice'); 
        $table->date('fromDate'); 
        $table->date('endDate');
        $table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');

        });
    }

    public function down()
    {
        Schema::dropIfExists('officereportingstructuremaster');
    }
}