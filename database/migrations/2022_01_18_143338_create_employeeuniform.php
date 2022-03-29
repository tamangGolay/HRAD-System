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
            $table->string('name'); 
            $table->string('contact_number'); 
            $table->foreignId('org_unit_id')->references('id')->on('orgUnit')->nullable();
            $table->string('shirt'); 
            $table->string('pant'); 
            $table->string('jacket'); 
            $table->string('raincoat'); 
            $table->integer('shoe'); 
            $table->integer('jumboot'); 
            $table->timestamps();
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
