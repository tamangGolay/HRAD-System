<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeuniform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeuniform', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('name',50); 
            $table->integer('contact_number')->unsigned(); 
            $table->foreignId('org_unit_id')->references('id')->on('orgUnit')->nullable();
            $table->tinyInteger('shirt'); 
            $table->tinyInteger('pant'); 
            $table->tinyInteger('jacket'); 
            $table->tinyInteger('raincoat'); 
            $table->tinyInteger('shoe'); 
            $table->tinyInteger('jumboot'); 
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->integer('createdBy')->unsigned()->nullable();
            $table->date('createdOn')->nullable();
            $table->integer('modifiedBy')->unsigned()->nullable();
            $table->date('modifiedOn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeeuniform');
    }
}
