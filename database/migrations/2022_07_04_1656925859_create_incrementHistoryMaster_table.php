<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateincrementhistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('incrementhistorymaster', function (Blueprint $table) {

		$table->integer('personalNo'); //fk md employee master
		$table->date('incrementDate');
		$table->integer('oldBasic');
        $table->integer('newBasic');
        $table->date('nextDue');
        $table->string('remarks');
        });
    }

    public function down()
    {
        Schema::dropIfExists('incrementhistorymaster');
    }
}