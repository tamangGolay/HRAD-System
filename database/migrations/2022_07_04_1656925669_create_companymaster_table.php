<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanymasterTable extends Migration
{
    public function up()
    {
        Schema::create('companymaster', function (Blueprint $table) {

            $table->id();   
		// $table->integer('companyId');
		$table->string('comNameShort');
		$table->string('comNameLong');
		$table->string('comReportsTo');
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
        Schema::dropIfExists('companymaster');
    }
}