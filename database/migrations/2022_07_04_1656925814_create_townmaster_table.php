<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTownmasterTable extends Migration
{
    public function up()
    {
        Schema::create('townmaster', function (Blueprint $table) {

		$table->integer('townId');
		$table->string('townName');
		$table->integer('gewogId');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('townmaster');
    }
}