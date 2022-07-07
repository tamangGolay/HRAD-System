<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateempreportingstructuremasterTable extends Migration
{
    public function up()
    {
        Schema::create('empreportingstructuremaster', function (Blueprint $table) {
            $table->id();
		$table->integer('personalNo')->references('id')->on('employeemaster');  //fk employee master
		$table->integer('reportsToOffice'); 
		$table->integer('reportsToEmployee');    
        $table->date('fromDate')->nullable(); 
        $table->date('endDate')->nullable();
        $table->integer('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('empreportingstructuremaster');
    }
}