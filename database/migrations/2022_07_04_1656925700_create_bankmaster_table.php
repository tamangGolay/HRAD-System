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
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
        $table->integer('status')->default(0);

        });
    }

    public function down()
    {
        Schema::dropIfExists('bankmaster');
    }
}