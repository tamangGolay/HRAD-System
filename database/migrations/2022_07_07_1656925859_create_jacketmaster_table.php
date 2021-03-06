<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJacketmasterTable extends Migration
{
    public function up()
    {
        Schema::create('jacketmaster', function (Blueprint $table) {

		$table->id();
		$table->string('sizeName');
		$table->string('usUkSize');
		$table->string('euSize');
		$table->string('gender');
        $table->tinyInteger('status')->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('jacketmaster');
    }
}