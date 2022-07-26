<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualilevelmasterTable extends Migration
{
    public function up()
    {
        Schema::create('qualilevelmaster', function (Blueprint $table) {

		$table->id();
		$table->string('qualiLevelName',50);
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();	
        });
    }

    public function down()
    {
        Schema::dropIfExists('qualilevelmaster');
    }
}