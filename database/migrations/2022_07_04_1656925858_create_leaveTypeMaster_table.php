<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateleavetypemasterTable extends Migration
{
    public function up()
    {
        Schema::create('leavetypemaster', function (Blueprint $table) {
        $table->id();
		$table->string('leaveType',30);  
        $table->tinyInteger('status')->default(0);
		$table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
       
        });
    }

    public function down()
    {
        Schema::dropIfExists('leavetypemaster');
    }
}