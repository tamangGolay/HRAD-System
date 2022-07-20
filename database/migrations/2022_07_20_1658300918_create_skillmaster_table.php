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
		$table->integer('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
        $table->date('updated_at');
        $table->date('created_at');
        });
    }
 
    public function down()
    {
        Schema::dropIfExists('skillmaster');
    }
}