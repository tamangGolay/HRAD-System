<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicemasterTable extends Migration
{
    public function up()
    {
        Schema::create('servicemaster', function (Blueprint $table) {

		$table->integer('ServiceId');
		$table->string('SerNameShort');
		$table->string('SerNameLong');
		$table->integer('ServiceHead');
		$table->integer('SerReportsToOffice');
		$table->integer('SerReportsToEmp');
		$table->integer('CreatedBy');
		$table->timestamp('CreatedOn');
		$table->integer('ModifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('servicemaster');
    }
}