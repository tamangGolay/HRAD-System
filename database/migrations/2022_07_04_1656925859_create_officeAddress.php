<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
 \DB::statement("
    create view office_address as
    select 
    place_data.placeId AS placeId,
    replace(concat(place_data.villageName,', ',place_data.gewogName,', ',place_data.drungkhagName,', ',place_data.dzongkhagName),'Not Applicable,','') AS Address from hradsystem.place_data where place_data.placeCategory = 'Village' 
    union 
    select place_data.placeId AS placeId,concat(place_data.townName,', ',place_data.dzongkhagName) AS Address from hradsystem.place_data where place_data.placeCategory = 'Town'
    union
    select place_data.placeId AS placeId,replace(concat(place_data.gewogName,', ',place_data.drungkhagName,', ',place_data.dzongkhagName),'Not Applicable,','') AS Address from hradsystem.place_data where place_data.placeCategory = 'Gewog' 
    union 
    select place_data.placeId AS placeId,concat(place_data.drungkhagName,', ',place_data.dzongkhagName) AS Address from hradsystem.place_data where place_data.placeCategory = 'Drungkhag' 
    union 
    select place_data.placeId AS placeId,concat(place_data.dzongkhagName) AS Address 
    from hradsystem.place_data where place_data.placeCategory = 'Dzongkhag'
    ");
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('office_address');
    }
}