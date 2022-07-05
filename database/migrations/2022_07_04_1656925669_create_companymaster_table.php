<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanymasterTable extends Migration
{
    public function up()
    {
        Schema::create('companymaster', function (Blueprint $table) {

		$table->integer('CompanyId');
		$table->string('ComNameShort');
		$table->string('ComNameLong');
		$table->integer('ComReportsTo');
		$table->integer('CreatedBy');
		$table->timestamp('CreatedOn');
		$table->integer('ModifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('companymaster');
    }
}