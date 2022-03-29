<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('emp_id')->unique();
            $table->string('password')->default('$2y$10$fDIw.1lGpnLMdBNWB2RlKuo1JfVi7IpHfxrTCr5NyaE2AtIf9qFFC');
            $table->rememberToken();
            $table->string('designation')->nullable();
            $table->string('contact_number')->nullable(); 
            $table->foreignId('org_unit_id')->references('id')->on('orgUnit');
            $table->tinyInteger('grade')->nullable();
            $table->tinyInteger('dzongkhag')->nullable();
            $table->string('gender')->nullable();
            $table->tinyInteger('conference_user')->nullable();
            $table->tinyInteger('status')->default(0); //zero - inactive. 1-active.
            $table->boolean('first_time_login')->default(true);
            $table->string('email')->nullable();
            $table->foreignId('role_id')->references('id')->on('roles')->nullable();

            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('users');
    }
}
