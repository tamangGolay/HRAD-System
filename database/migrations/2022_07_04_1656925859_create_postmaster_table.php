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
		$table->string('shortName',10);
		$table->string('longName');
		$table->integer('positionSpecificAllowance');
		$table->integer('contractAllowance');
		$table->integer('communicationAllowance');
		$table->string('type',100);
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();   
        $table->tinyInteger('status')->unsigned()->default(0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('postmaster');
    }
}