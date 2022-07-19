<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfbalanceTable extends Migration
{
    public function up()
    {
        Schema::create('wfbalance', function (Blueprint $table) {
            $table->string('balance');
        ;

        });
    }

    public function down()
    {
        Schema::dropIfExists('wfbalance');
    }
}