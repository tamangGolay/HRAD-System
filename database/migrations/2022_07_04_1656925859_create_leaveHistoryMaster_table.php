<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateleavehistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('leavehistorymaster', function (Blueprint $table) {

		$table->integer('personalNo');  //fk to master employee
		$table->date('applicationDate'); 
		$table->string('leaveType');    //fk md leave_type
        $table->date('from'); 
        $table->date('to'); 
        $table->integer('leavePeriod'); 
        $table->string('status'); 
        $table->string('remarks'); 

        });
    }

    public function down()
    {
        Schema::dropIfExists('leavehistorymaster');
    }
}