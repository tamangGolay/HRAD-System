<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationmasterTable extends Migration
{
    public function up()
    {
        Schema::create('designationmaster', function (Blueprint $table) {

		$table->integer('designationId');
		$table->string('desisNameShort');
		$table->string('desisNameLong');
		$table->integer('dreatedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('designationmaster');
    }
}