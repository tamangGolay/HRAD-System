<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateeassummaryhistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('eassummaryhistorymaster', function (Blueprint $table) {

        $table->integer('personalNo')->references('id')->on('employeemaster');  //fk md employee master
		$table->integer('year');
        $table->integer('rating');
        $table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');

        });
    }

    public function down()
    {
        Schema::dropIfExists('eassummaryhistorymaster');
    }
}