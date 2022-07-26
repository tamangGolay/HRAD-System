<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeadminTable extends Migration
{
    public function up()
    {
        Schema::create('officeadmin', function (Blueprint $table) {

		$table->id();        
        $table->foreignId('officeId')->references('id')->on('officemaster')->nullable();       
        $table->integer('officeAdmin')->nullable();
        $table->tinyInteger('status')->default(0);
		$table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();
        
        
        
        // $table->date('updated_at')->nullable();
        // $table->date('created_at')->nullable();
        
 
        });
    }

    public function down()
    {
        Schema::dropIfExists('officeadmin');
    }
}