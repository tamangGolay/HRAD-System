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
		$table->foreignId('officeId')->references('id')->on('officemaster');    //fk office master 
		$table->integer('reportsToOffice'); 
        $table->date('fromDate'); 
        $table->date('endDate');
        $table->integer('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('officereportingstructuremaster');
    }
}