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
        $table->foreignId('qualificationLevelId')->references('id')->on('qualilevelmaster');
		$table->string('qualificationShortName');
        $table->string('qualificationLongName');
        $table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
        $table->integer('modifiedOn');

		
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('qualificationmaster');
    }
}