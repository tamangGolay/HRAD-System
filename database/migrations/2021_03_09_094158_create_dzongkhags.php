<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDzongkhags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dzongkhags', function (Blueprint $table) {

            $table->id();            
            $table->string('Dzongkhag_Name',30);
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
        Schema::dropIfExists('dzongkhags');
    }
}
