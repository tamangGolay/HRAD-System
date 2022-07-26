<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatepromotionhistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('promotionhistorymaster', function (Blueprint $table) {
        
        $table->id();
		$table->foreignId('personalNo')->references('id')->on('users');  //fk md employee master
		$table->date('promotionDate');
        // $table->foreignId('gradeFrom')->references('id')->on('payscalemaster');
        $table->integer('gradeFrom');

        // $table->foreignId('gradeTo')->references('id')->on('payscalemaster');
        $table->integer('gradeTo');  
        $table->date('nextDue');

        $table->string('remarks');
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();   
        $table->tinyInteger('status')->unsigned()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotionhistorymaster');
    }
}