<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfrefundTable extends Migration
{
    public function up()
    {
        Schema::create('wfrefund', function (Blueprint $table) {

        $table->id();
		$table->integer('empId');
		$table->date('refundDate');
        $table->decimal('refundAmount',8,2);
        $table->tinyInteger('status')->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
        

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfrefund');
    }
}