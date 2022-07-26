<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatepayscalemasterTable extends Migration
{
    public function up()
    {
        Schema::create('payscalemaster', function (Blueprint $table) {
        $table->id();
		$table->string('grade',3);  
		$table->integer('low'); 
		$table->integer('increment');    
        $table->integer('high'); 
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();   
        $table->tinyInteger('status')->unsigned()->default(0);
        

        });
    }

    public function down()
    {
        Schema::dropIfExists('payscalemaster');
    }
}