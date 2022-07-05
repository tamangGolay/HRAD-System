<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankmasterTable extends Migration
{
    public function up()
    {
        Schema::create('bankmaster', function (Blueprint $table) {

		$table->id();
		$table->string('bankName');
        $table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bankmaster');
    }
}