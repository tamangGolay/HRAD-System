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
        $table->integer('villageId')->unique();
        $table->string('villageName');
        $table->foreignId('gewogId')->references('id')->on('gewogmaster');
		$table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();		
        $table->integer('status')->default(0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('villagemaster');
    }
}