<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrungkhagmasterTable extends Migration
{
    public function up()
    {
        Schema::create('drungkhagmaster', function (Blueprint $table) {

		$table->integer('drungkhagId');
		$table->string('drungkhagName');
		$table->integer('dzongkhag');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('drungkhagmaster');
    }
}