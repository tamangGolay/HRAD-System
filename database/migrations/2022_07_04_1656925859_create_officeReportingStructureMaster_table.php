<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateofficereportingstructuremasterTable extends Migration
{
    public function up()
    {
        Schema::create('officereportingstructuremaster', function (Blueprint $table) {

		$table->integer('officeId');   //fk office master 
		$table->integer('reportsToOffice');  //fk office master 
        $table->date('fromDate'); 
        $table->date('endDate');
        

        });
    }

    public function down()
    {
        Schema::dropIfExists('officereportingstructuremaster');
    }
}