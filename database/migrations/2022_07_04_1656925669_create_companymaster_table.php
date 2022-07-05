<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanymasterTable extends Migration
{
    public function up()
    {
        Schema::create('companymaster', function (Blueprint $table) {

		$table->integer('companyId');
		$table->string('comNameShort');
		$table->string('comNameLong');
		$table->integer('comReportsTo');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('companymaster');
    }
}