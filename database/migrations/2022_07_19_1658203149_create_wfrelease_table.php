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
		$table->decimal('amount',8,2);
        $table->foreignId('deathOf')->references('id')->on('familydetailsmaster');
        $table->string('reason');
        $table->tinyInteger('status')->unsigned()->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfrelease');
    }
}