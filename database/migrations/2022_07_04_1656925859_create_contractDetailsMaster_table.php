<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatecontractdetailsmasterTable extends Migration
{
    public function up()
    {
        Schema::create('contractdetailsmaster', function (Blueprint $table) {

		$table->integer('personalNo');  // fk md master employee
		$table->date('startDate');
		$table->date('endDate');
        $table->integer('termNo');

        });
    }

    public function down()
    {
        Schema::dropIfExists('contractdetailsmaster');
    }
}