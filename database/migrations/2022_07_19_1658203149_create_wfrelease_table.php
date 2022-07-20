<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfreleaseTable extends Migration
{
    public function up()
    {
        Schema::create('wfrelease', function (Blueprint $table) {
        $table->id();
		$table->integer('empId');
		$table->date('releaseDate');
		$table->float('amount');
		$table->string('reason');
        $table->integer('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->timestamp('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfrelease');
    }
}