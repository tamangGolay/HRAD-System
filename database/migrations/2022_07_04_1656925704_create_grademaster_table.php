<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrademasterTable extends Migration
{
    public function up()
    {
        Schema::create('grademaster', function (Blueprint $table) {

            $table->id();

            $table->string('Grade');
		$table->char('Level');

        });
    }

    public function down()
    {
        Schema::dropIfExists('grademaster');
    }
}