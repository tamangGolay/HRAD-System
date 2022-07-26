<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfcontributionTable extends Migration
{
    public function up()
    {
        Schema::create('wfcontribution', function (Blueprint $table) {

      
        $table->integer('empId',8);
		$table->date('contributionDate');
		$table->integer('year');
		$table->integer('month');
		$table->decimal('amount',10,2);
        $table->integer('officeId');
        $table->tinyInteger('status')->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
        

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfcontribution');
    }
}