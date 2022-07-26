<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldmasterTable extends Migration
{
    public function up()
    {
        Schema::create('fieldmaster', function (Blueprint $table) {

		$table->id();
		$table->string('fieldName',30);
        $table->tinyInteger('status')->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fieldmaster');
    }
}