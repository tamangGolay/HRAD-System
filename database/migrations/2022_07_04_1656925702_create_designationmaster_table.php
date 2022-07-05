<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationmasterTable extends Migration
{
    public function up()
    {
        Schema::create('designationmaster', function (Blueprint $table) {

		$table->integer('DesignationId');
		$table->string('DesisNameShort');
		$table->string('DesisNameLong');
		$table->integer('CreatedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('designationmaster');
    }
}