<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedisplinaryhistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('displinaryhistorymaster', function (Blueprint $table) {
        $table->id();
		$table->foreignId('personalNo')->references('id')->on('users'); //fk md employee master
		$table->date('incrementDate');
		$table->string('case');
        $table->string('actionTaken');
        $table->integer('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
        $table->timestamp('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('displinaryhistorymaster');
    }
}