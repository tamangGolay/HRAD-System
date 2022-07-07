<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatecontractdetailsmasterTable extends Migration
{
    public function up()
    {
        Schema::create('contractdetailsmaster', function (Blueprint $table) {
        $table->id();
		$table->integer('personalNo');  // fk md master employee 
		$table->date('startDate')->nullable();;
		$table->date('endDate')->nullable();;
        $table->integer('termNo');
        $table->integer('status')->default(0);
		$table->integer('createdBy')->nullable();;
		$table->timestamp('createdOn')->nullable();;
		$table->integer('modifiedBy')->nullable();;
		$table->integer('modifiedOn')->nullable();;
        });
    }

    public function down()
    {
        Schema::dropIfExists('contractdetailsmaster');
    }
}