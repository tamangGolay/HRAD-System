<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficemasterTable extends Migration
{
    public function up()
    {
        Schema::create('officemaster', function (Blueprint $table) {

		$table->id('OfficeId');
		$table->integer('OfficeType');
		$table->integer('OfficeLinkId');
		$table->integer('OfficeAddress');
		$table->integer('CreatedBy');
		$table->timestamp('CreatedOn');
		$table->integer('ModifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('officemaster');
    }
}