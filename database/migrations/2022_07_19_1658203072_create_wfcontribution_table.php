<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfcontributionTable extends Migration
{
    public function up()
    {
        Schema::create('wfcontribution', function (Blueprint $table) {

		$table->integer('empId',8);
		$table->date('contributionDate');
		$table->integer('year');
		$table->integer('month');
		$table->double('amount');
        $table->integer('officeId');
        $table->timestamp('updated_at')->nullable();
		$table->timestamp('created_at')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfcontribution');
    }
}