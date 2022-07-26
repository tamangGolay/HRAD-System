<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsubcategoryTable extends Migration
{
    public function up()
    {
        Schema::create('skillsubcategory', function (Blueprint $table) {
        $table->id();
		$table->string('subCatName');
		$table->foreignId('catId')->references('id')->on('skillcategorymaster');		
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();	

        });
    }

    public function down()
    {
        Schema::dropIfExists('skillsubcategory');
    }
}