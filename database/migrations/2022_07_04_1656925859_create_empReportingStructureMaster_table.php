<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateempreportingstructuremasterTable extends Migration
{
    public function up()
    {
        Schema::create('empreportingstructuremaster', function (Blueprint $table) {

		$table->integer('personalNo');   //fk employee master
		$table->integer('reportsToOffice'); 
		$table->integer('reportsToEmployee');    
        $table->date('fromDate'); 
        $table->date('endDate');
        

        });
    }

    public function down()
    {
        Schema::dropIfExists('empreportingstructuremaster');
    }
}