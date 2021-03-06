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
        $table->foreignId('officeAddress')->references('id')->on('placemaster')->nullable();
        $table->string('officeHead')->nullable();
        $table->string('status')->default(0);
        $table->string('reportToOffice')->nullable();
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->timestamp('modifiedOn')->nullable();
       
 
        });
    }

    public function down()
    {
        Schema::dropIfExists('officemaster');
    }
}