<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfreleaseTable extends Migration
{
    public function up()
    {
        Schema::create('wfrelease', function (Blueprint $table) {

		$table->integer('EmpId',8);
		$table->date('releaseDate');
		;
		$table->string('reason',50);

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfrelease');
    }
}