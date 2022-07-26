<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfbalanceTable extends Migration
{
    public function up()
    {
        Schema::create('wfbalance', function (Blueprint $table) {
            $table->decimal('balance',15,2);
            $table->tinyInteger('status')->default(0);
        $table->integer('createdBy')->unsigned()->nullable();
        $table->date('createdOn')->nullable();
        $table->integer('modifiedBy')->unsigned()->nullable();
        $table->date('modifiedOn')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfbalance');
    }
}