<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillmasterTable extends Migration
{
    public function up()
    {
        Schema::create('skillmaster', function (Blueprint $table) {

		$table->integer('skillId');
		$table->string('skillName');
		$table->integer('subCatId')->nullable();
		$table->integer('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skillmaster');
    }
}