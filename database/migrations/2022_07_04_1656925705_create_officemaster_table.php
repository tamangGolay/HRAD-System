<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficemasterTable extends Migration
{
    public function up()
    {
        Schema::create('officemaster', function (Blueprint $table) {

		$table->id();
        $table->foreignId('officeName')->references('id')->on('officename');
        $table->foreignId('officeAddress')->references('id')->on('placemaster');
        $table->integer('officeHead');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('officemaster');
    }
}