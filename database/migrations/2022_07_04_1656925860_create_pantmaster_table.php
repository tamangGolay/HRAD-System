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
		$table->string('pantSizeName');       
        $table->string('gender');
        $table->integer('status')->default(0);             
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->timestamp('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pantmaster');
    }
}