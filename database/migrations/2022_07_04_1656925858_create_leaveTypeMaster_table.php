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
		$table->string('leaveType');  
        $table->string('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
       
        });
    }

    public function down()
    {
        Schema::dropIfExists('leavetypemaster');
    }
}