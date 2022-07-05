<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGewogmasterTable extends Migration
{
    public function up()
    {
        Schema::create('gewogmaster', function (Blueprint $table) {

		$table->id();
		$table->string('gewogName');
        $table->foreignId('dzongkhagId')->references('id')->on('dzongkhagmaster');
        $table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gewogmaster');
    }
}