<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePantmasterTable extends Migration
{
    public function up()
    {
        Schema::create('pantmaster', function (Blueprint $table) {

		$table->id();
		$table->string('pantSizeName',100);       
        $table->string('gender',20);
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();   
        $table->tinyInteger('status')->unsigned()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pantmaster');
    }
}