<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillcategorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('skillcategorymaster', function (Blueprint $table) {

		$table->id();
		$table->string('categoryName');
        $table->string('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->date('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('skillcategorymaster');
    }
}
