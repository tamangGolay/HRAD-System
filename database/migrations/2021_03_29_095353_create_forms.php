<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('forms',50);
            $table->string('description',50);
            $table->string('group',50)->nullable();
            $table->string('menu',10)->default('yes');
            $table->string('icon',20)->nullable();
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
        Schema::dropIfExists('forms');
    }
}
