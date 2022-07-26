<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillmasterTable extends Migration
{
    public function up()
    {
        Schema::create('skillmaster', function (Blueprint $table) {

		// $table->id('skillId');
        $table->id();
		$table->string('skillName');
		$table->foreignId('subCatId')->references('id')->on('skillsubcategory');  // fk md master skill sub category 
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();	
        
        });
    }
 
    public function down()
    {
        Schema::dropIfExists('skillmaster');
    }
}