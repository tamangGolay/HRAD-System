<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateleavebalancemasterTable extends Migration
{
    public function up()
    {
        Schema::create('leavebalancemaster', function (Blueprint $table) {

		$table->integer('personalNo')->references('id')->on('users');  //fk to master employee
		$table->decimal('casualLeaveBalance',5,2); 
		$table->decimal('earnedLeaveBalance',5,2); 
		$table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leavebalancemaster');
    }
}