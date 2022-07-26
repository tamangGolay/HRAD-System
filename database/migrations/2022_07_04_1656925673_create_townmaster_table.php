<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTownmasterTable extends Migration
{
    public function up()
    {
        Schema::create('townmaster', function (Blueprint $table) {

		$table->id();
		$table->string('townName',100);
        $table->string('townClass',100);
        $table->foreignId('dzongkhagId')->references('id')->on('dzongkhags');
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();	

        });
    }

    public function down()
    {
        Schema::dropIfExists('townmaster');
    }
}