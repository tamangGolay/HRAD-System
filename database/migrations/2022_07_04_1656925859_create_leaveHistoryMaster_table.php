<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateleavehistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('leavehistorymaster', function (Blueprint $table) {

		$table->integer('personalNo')->references('id')->on('users');  //fk to master employee
		$table->date('applicationDate'); 
		$table->string('leaveType')->references('id')->on('leavetypemaster');   //fk md leave_type
        $table->date('from'); 
        $table->date('to'); 
        $table->integer('leavePeriod'); 
        $table->string('remarks'); 
        $table->tinyInteger('status')->default(0);
		$table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leavehistorymaster');
    }
}