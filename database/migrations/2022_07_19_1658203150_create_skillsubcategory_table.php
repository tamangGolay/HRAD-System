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
		$table->integer('catId');		
        $table->integer('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->timestamp('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('skillsubcategory');
    }
}