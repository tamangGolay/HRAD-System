<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfrefundTable extends Migration
{
    public function up()
    {
        Schema::create('wfrefund', function (Blueprint $table) {

		$table->integer('empId',8);
		$table->date('refundDate');
        $table->integer('refundAmount');
		$table->integer('status')->default(0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfrefund');
    }
}