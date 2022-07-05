<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicemasterTable extends Migration
{
    public function up()
    {
        Schema::create('servicemaster', function (Blueprint $table) {

		$table->integer('serviceId');
		$table->string('serNameShort');
		$table->string('serNameLong');
		$table->integer('serviceHead');
		$table->integer('serReportsToOffice');
		$table->integer('serReportsToEmp');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('servicemaster');
    }
}