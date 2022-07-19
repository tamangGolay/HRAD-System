<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfbankTable extends Migration
{
    public function up()
    {
        Schema::create('wfbank', function (Blueprint $table) {

		$table->date('date');
		$table->string('narration',50);
		$table->string('transaction')->default('NULL');
		;

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfbank');
    }
}