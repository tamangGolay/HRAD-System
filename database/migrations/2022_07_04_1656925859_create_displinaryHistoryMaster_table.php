<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedisplinaryhistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('displinaryhistorymaster', function (Blueprint $table) {

		$table->integer('personalNo'); //fk md employee master
		$table->date('incrementDate');
		$table->string('case');
        $table->string('action');
        $table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('displinaryhistorymaster');
    }
}