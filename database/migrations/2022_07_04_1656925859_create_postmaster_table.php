<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostmasterTable extends Migration
{
    public function up()
    {
        Schema::create('postmaster', function (Blueprint $table) {

		$table->id();
		$table->string('shortName');
		$table->string('longName');
		$table->integer('positionSpecificAllowance');
		$table->integer('contractAllowance');
		$table->integer('communicationAllowance');
		$table->string('type');
        $table->integer('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable(); 
		$table->integer('modifiedBy')->nullable(); 
		$table->integer('modifiedOn')->nullable(); 

        });
    }

    public function down()
    {
        Schema::dropIfExists('postmaster');
    }
}