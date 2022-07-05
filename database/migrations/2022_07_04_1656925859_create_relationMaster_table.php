<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreaterelationmasterTable extends Migration
{
    public function up()
    {
        Schema::create('relationmaster', function (Blueprint $table) {

		
		$table->string('relationshipName');
		
        });
    }

    public function down()
    {
        Schema::dropIfExists('relationmaster');
    }
}