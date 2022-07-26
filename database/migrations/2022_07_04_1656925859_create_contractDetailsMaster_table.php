<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatecontractdetailsmasterTable extends Migration
{
    public function up()
    {
        Schema::create('contractdetailsmaster', function (Blueprint $table) {
        $table->id();
		$table->foreignId('personalNo')->references('id')->on('users');  // fk md master employee 
		$table->date('startDate');
		$table->date('endDate');
        $table->tinyInteger('termNo')->unsigned();
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();
        $table->tinyInteger('status')->unsigned()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('contractdetailsmaster');
    }
}