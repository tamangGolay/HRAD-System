<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreaterelationmasterTable extends Migration
{
    public function up()
    {
        Schema::create('relationmaster', function (Blueprint $table) {

        $table->id();
		$table->string('relationshipName',100);
        $table->string('verification',255);
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();	
        });
    }

    public function down()
    {
        Schema::dropIfExists('relationmaster');
    }
}