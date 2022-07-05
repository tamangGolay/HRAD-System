<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubdivisionmasterTable extends Migration
{
    public function up()
    {
        Schema::create('subdivisionmaster', function (Blueprint $table) {

		$table->integer('subDivisionid');
		$table->string('subDivnameShort');
		$table->string('subDivnameLong');
		$table->integer('subDivhead');
		$table->integer('subDivreportsTodivision');
		$table->integer('subDivreportsTodepartment');
		$table->integer('subDivreportsToservice');
		$table->integer('subDivreportsTocompany');
		$table->integer('subDivreportsToemp');
		$table->integer('createdBy');
		$table->timestamp('createdOn');
		$table->integer('modifiedBy');

        });
    }

    public function down()
    {
        Schema::dropIfExists('subdivisionmaster');
    }
}