<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateempreportingstructuremasterTable extends Migration
{
    public function up()
    {
        Schema::create('empreportingstructuremaster', function (Blueprint $table) {

		$table->integer('personalNo')->references('id')->on('employeemaster');  //fk employee master
		$table->integer('reportsToOffice'); 
		$table->integer('reportsToEmployee');    
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
        Schema::dropIfExists('empreportingstructuremaster');
    }
}