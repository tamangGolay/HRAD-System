<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicleRequest', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->foreignId('org_unit_id')->references('id')->on('orgUnit');
            $table->string('vname');
            $table->string('email');
            $table->string('designationVf')->nullable();         
            $table->date('dateOfRequisition');                      
            $table->date('start_date');
            $table->date('end_date'); 
            $table->foreignId('vehicleId')->nullable();       
            $table->string('purpose');            
            $table->text('placesToVisit');   
            $table->string('reason')->nullable();            
            $table->string('supervisor')->nullable();            
            $table->string('mto')->nullable();
            $table->integer('status')->default(0);
            $table->string('personalvehicle');


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
        Schema::dropIfExists('vehiclerequest');
    }
}
