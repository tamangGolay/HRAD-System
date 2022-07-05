<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficenameTable extends Migration
{
    public function up()
    {
        Schema::create('officename', function (Blueprint $table) {

		$table->id();
		$table->string('shortOfficeName');
		$table->string('longOfficeName');
        $table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');
		$table->integer('modifiedOn');

        });
    }

    public function down()
    {
        Schema::dropIfExists('officename');
    }
}