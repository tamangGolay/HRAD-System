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
		$table->foreignId('personalNo')->references('id')->on('users'); //fk md employee master
		$table->date('incrementDate');
		$table->integer('oldBasic');
        $table->integer('newBasic');
        $table->date('nextDue');
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
        Schema::dropIfExists('incrementhistorymaster');
    }
}