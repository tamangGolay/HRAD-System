<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationmasterTable extends Migration
{
    public function up()
    {
        Schema::create('qualificationmaster', function (Blueprint $table) {
        $table->id();        
		$table->string('qualificationName',100);        
        $table->foreignId('qualificationLevelId')->references('id')->on('qualilevelmaster');
        $table->foreignId('qualificationField')->references('id')->on('fieldmaster');
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();	
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('qualificationmaster');
    }
}