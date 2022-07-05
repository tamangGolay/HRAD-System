<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatepromotionhistorymasterTable extends Migration
{
    public function up()
    {
        Schema::create('promotionhistorymaster', function (Blueprint $table) {

		$table->integer('personalNo');  //fk md employee master
		$table->date('promotionDate');
        $table->string('gradeFrom');
        $table->string('gradeTo');
        $table->date('nextDue');
        $table->string('remarks');

        });
    }

    public function down()
    {
        Schema::dropIfExists('promotionhistorymaster');
    }
}