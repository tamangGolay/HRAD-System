<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeskillmapTable extends Migration
{
    public function up()
    {
        Schema::create('employeeskillmap', function (Blueprint $table) {

        $table->id();
		$table->foreignId('pNo')->references('id')->on('users');
		$table->foreignId('skillId')->references('id')->on('skillcategorymaster');
        $table->date('obtainedOn');
		$table->date('expiryDate');
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employeeskillmap');
    }
}