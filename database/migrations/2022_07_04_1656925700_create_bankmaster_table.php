<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankmasterTable extends Migration
{
    public function up()
    {
        Schema::create('bankmaster', function (Blueprint $table) {

		$table->smallInteger('id',2);
		$table->string('bankName',100);
        $table->integer('createdBy')->unsigned()->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->unsigned()->nullable();
		$table->date('modifiedOn')->nullable();
        $table->tinyInteger('status')->unsigned()->default(0);


        });
    }

    public function down()
    {
        Schema::dropIfExists('bankmaster');
    }
}