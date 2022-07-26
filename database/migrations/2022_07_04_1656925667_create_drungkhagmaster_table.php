<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrungkhagmasterTable extends Migration
{
    public function up()
    {
        Schema::create('drungkhagmaster', function (Blueprint $table) {

		$table->id();
		$table->string('drungkhagName',50);
        $table->foreignId('dzongkhagId')->references('id')->on('dzongkhags');        
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();   
        $table->tinyInteger('status')->unsigned()->default(0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('drungkhagmaster');
    }
}