<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoesizeTable extends Migration
{
    public function up()
    {
        Schema::create('shoesize', function (Blueprint $table) {

		$table->id();
		$table->decimal('usShoeSize');
		$table->decimal('ukShoeSize');
		$table->decimal('euShoeSize');
		$table->string('footLengthInches');
		$table->decimal('footLengthCm');
		$table->string('gender');
		$table->string('status')->default(0);
		$table->integer('createdBy')->nullable();
		$table->date('createdOn')->nullable();
		$table->integer('modifiedBy')->nullable();
		$table->date('modifiedOn')->nullable();
		$table->date('updated_at');
        $table->date('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shoesize');
    }
}