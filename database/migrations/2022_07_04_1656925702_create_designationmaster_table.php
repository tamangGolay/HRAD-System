<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationmasterTable extends Migration
{
    public function up()
    {
        Schema::create('designationmaster', function (Blueprint $table) {

		$table->id();
		$table->string('desisNameShort');
		$table->string('desisNameLong');
        $table->string('status')->default(0);
        $table->integer('createdBy')->nullable();
		$table->timestamp('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->integer('modifiedOn')->nullable();
        $table->date('updated_at');
        $table->date('created_at');

		

        });
    }

    public function down()
    {
        Schema::dropIfExists('designationmaster');
    }
}