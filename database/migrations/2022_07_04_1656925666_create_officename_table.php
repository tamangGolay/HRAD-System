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
		$table->string('shortOfficeName',10);
		$table->string('longOfficeName',150);
        $table->string('officeType',25);
        $table->tinyInteger('status')->default(0);
		$table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
//

        });
    }

    public function down()
    {
        Schema::dropIfExists('officename');
    }
}