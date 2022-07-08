<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateincrementhistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('incrementhistorymaster', function (Blueprint $table) {
            $table->id();
		$table->foreignId('personalNo')->references('id')->on('employeemaster'); //fk md employee master
		$table->date('incrementDate');
		$table->integer('oldBasic');
        $table->integer('newBasic');
        $table->date('nextDue');
        $table->string('remarks');
        $table->integer('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('incrementhistorymaster');
    }
}