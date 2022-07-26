<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfrelativesTable extends Migration
{
    public function up()
    {
        Schema::create('wfrelatives', function (Blueprint $table) {

		$table->integer('employeeId',8);
		$table->integer('cIdNo');
		$table->string('cIDOther',30);
		$table->string('name',50);
		$table->date('doB');
		$table->integer('relation');
		$table->string('status')->default('Active');//Active/Deceased/Separated
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wfrelatives');
    }
}