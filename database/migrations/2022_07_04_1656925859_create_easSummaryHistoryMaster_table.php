<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateeassummaryhistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('eassummaryhistorymaster', function (Blueprint $table) {

		$table->integer('personalNo');  //fk md employee master
		$table->integer('year');
        $table->integer('rating');
       

        });
    }

    public function down()
    {
        Schema::dropIfExists('eassummaryhistorymaster');
    }
}