<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfbankTable extends Migration
{
    public function up()
    {
        Schema::create('wfbank', function (Blueprint $table) {
        
        $table->id();
		$table->date('date');
		$table->string('narration');
        $table->enum('transaction', ['CR', 'DR'])->default('CR');
		$table->decimal('amount',10,2);
        $table->tinyInteger('status')->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfbank');
    }
}