<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillagemasterTable extends Migration
{
    public function up()
    {
        Schema::create('villagemaster', function (Blueprint $table) {

		$table->id();
        $table->integer('villageId')->default(10000);
        $table->string('villageName',100);
        $table->foreignId('gewogId')->references('id')->on('gewogmaster');
		$table->tinyInteger('status')->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('villagemaster');
    }
}