<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGewogmasterTable extends Migration
{
    public function up()
    {
        Schema::create('gewogmaster', function (Blueprint $table) {

		$table->id();
		$table->string('gewogName',100);
        $table->foreignId('drungkhagId')->references('id')->on('drungkhagmaster');
        // $table->integer('drungkhagId');
        $table->foreignId('dzongkhagId')->references('id')->on('dzongkhags');
        $table->tinyInteger('status')->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gewogmaster');
    }
}