<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficemasterTable extends Migration
{
    public function up()
    {
        Schema::create('officemaster', function (Blueprint $table) {

		$table->id('officeId');
		$table->integer('officeType');
		$table->integer('officeLinkId');
		$table->integer('officeAddress');
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