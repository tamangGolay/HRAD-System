<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleFormMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roleFormMapping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->references('id')->on('roles');
            $table->foreignId('form_id')->references('id')->on('forms');
            $table->foreignId('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('roleFormMapping');
    }
}
