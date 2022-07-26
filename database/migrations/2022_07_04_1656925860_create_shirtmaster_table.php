<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShirtmasterTable extends Migration
{
    public function up()
    {
        Schema::create('shirtmaster', function (Blueprint $table) {

		$table->id();
		$table->string('shirtSizeName',10);       
        // $table->string('gender');
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
        Schema::dropIfExists('shirtmaster');
    }
}