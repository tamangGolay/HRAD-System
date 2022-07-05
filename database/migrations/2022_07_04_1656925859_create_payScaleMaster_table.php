<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatepayscalemasterTable extends Migration
{
    public function up()
    {
        Schema::create('payscalemaster', function (Blueprint $table) {

		$table->string('grade');  
		$table->integer('low'); 
		$table->integer('increment');    
        $table->integer('high'); 
        

        });
    }

    public function down()
    {
        Schema::dropIfExists('payscalemaster');
    }
}