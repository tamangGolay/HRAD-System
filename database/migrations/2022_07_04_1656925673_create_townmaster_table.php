<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTownmasterTable extends Migration
{
    public function up()
    {
        Schema::create('townmaster', function (Blueprint $table) {

		$table->id();
		$table->string('townName');
        $table->string('townClass');
        $table->foreignId('dzongkhagId')->references('id')->on('dzongkhags');
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
        $table->integer('status')->default(0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('townmaster');
    }
}