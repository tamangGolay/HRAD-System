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
		$table->decimal('usShoeSize',8,2);
		$table->decimal('ukShoeSize',8,2);
		$table->decimal('euShoeSize',8,2);
		$table->decimal('footLengthInches',5,2);
		$table->decimal('footLengthCm',5,2);
		$table->enum('gender', ['Male', 'Female', 'Other'])->default('Male');
		$table->tinyInteger('status')->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();

		
        });
    }

    public function down()
    {
        Schema::dropIfExists('shoesize');
    }
}