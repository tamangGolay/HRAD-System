<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedisplinaryhistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('displinaryhistorymaster', function (Blueprint $table) {
        $table->id();
		$table->foreignId('personalNo')->references('id')->on('users'); //fk md employee master
		$table->date('issueDate');
		$table->string('case');
        $table->string('actionTaken');
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();  
        });
    }

    public function down()
    {
        Schema::dropIfExists('displinaryhistorymaster');
    }
}