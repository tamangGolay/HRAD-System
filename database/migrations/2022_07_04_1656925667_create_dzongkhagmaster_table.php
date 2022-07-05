<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDzongkhagmasterTable extends Migration
{
    public function up()
    {
        Schema::create('dzongkhagmaster', function (Blueprint $table) {

		$table->id();
		$table->string('dzongkhagName');
        $table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');

        });
    }

    public function down()
    {
        Schema::dropIfExists('dzongkhagmaster');
    }
}