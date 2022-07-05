<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatepromotionhistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('promotionhistorymaster', function (Blueprint $table) {

		$table->integer('personalNo')->references('id')->on('employeemaster');  //fk md employee master
		$table->date('promotionDate');
        $table->string('gradeFrom');
        $table->string('gradeTo');
        $table->date('nextDue');
        $table->string('remarks');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotionhistorymaster');
    }
}