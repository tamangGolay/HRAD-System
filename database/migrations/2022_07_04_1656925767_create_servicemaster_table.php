<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicemasterTable extends Migration
{
    public function up()
    {
        Schema::create('servicemaster', function (Blueprint $table) {

		$table->id();
		$table->string('serNameShort');
		$table->string('serNameLong');
		$table->foreignId('serviceHead')->references('id')->on('users');
		$table->foreignId('company')->references('id')->on('companymaster');
        $table->integer('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servicemaster');
    }
}