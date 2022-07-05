<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetransfermasterTable extends Migration
{
    public function up()
    {
        Schema::create('transfermaster', function (Blueprint $table) {

		$table->integer('personalNo');  //fk md employee master
		$table->date('transferDate');
        $table->string('transferFrom'); //fk md officeMaster
        $table->string('transferTo');//fk md officeMaster
        $table->date('status');
        $table->string('remarks');

        });
    }

    public function down()
    {
        Schema::dropIfExists('transfermaster');
    }
}