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
		$table->foreignId('personalNo')->references('id')->on('employeemaster');  //fk md employee master
		$table->date('promotionDate');
        $table->foreignId('gradeFrom')->references('id')->on('grademaster');
        $table->foreignId('gradeTo')->references('id')->on('grademaster'); 
        $table->date('nextDue');
        $table->string('remarks');
        $table->integer('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotionhistorymaster');
    }
}