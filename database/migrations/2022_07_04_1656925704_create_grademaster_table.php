<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrademasterTable extends Migration
{
    public function up()
    {
        Schema::create('grademaster', function (Blueprint $table) {

            $table->id();
            $table->string('grade');
		    $table->char('level');
            $table->integer('status')->default(0);
            $table->integer('createdBy')->nullable();
            $table->timestamp('createdOn')->nullable();
            $table->integer('modifiedBy')->nullable();
            $table->integer('modifiedOn')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grademaster');
    }
}