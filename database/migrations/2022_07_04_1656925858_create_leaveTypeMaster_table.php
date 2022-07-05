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
        $table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');

        });
    }

    public function down()
    {
        Schema::dropIfExists('leavetypemaster');
    }
}