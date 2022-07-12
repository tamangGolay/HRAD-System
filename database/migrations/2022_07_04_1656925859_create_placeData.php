<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
 \DB::statement("
        create view place_data as
        select 
        hradsystem.placemaster.id AS placeId,
        hradsystem.placemaster.villageId AS villageId,
        hradsystem.villagemaster.villageName AS villageName,
        hradsystem.placemaster.townId AS townId,
        hradsystem.townmaster.townName AS townName,
        hradsystem.placemaster.gewogId AS gewogId,
        hradsystem.gewogmaster.gewogName AS gewogName,
        hradsystem.placemaster.drungkhagId AS drungkhagId,
        hradsystem.drungkhagmaster.drungkhagName AS drungkhagName,
        hradsystem.placemaster.dzongkhagId AS dzongkhagId,
        hradsystem.dzongkhags.Dzongkhag_Name AS dzongkhagName,
        hradsystem.placemaster.placeCategory AS placeCategory 
        from hradsystem.placemaster, 
        hradsystem.villagemaster,
        hradsystem.townmaster,
        hradsystem.gewogmaster,
        hradsystem.drungkhagmaster,
        hradsystem.dzongkhags
        where hradsystem.placemaster.villageId = hradsystem.villagemaster.villageId 
        and hradsystem.placemaster.townId = hradsystem.townmaster.id 
        and hradsystem.placemaster.gewogId = hradsystem.gewogmaster.id 
        and hradsystem.placemaster.drungkhagId = hradsystem.drungkhagmaster.id 
        and hradsystem.placemaster.dzongkhagId = hradsystem.dzongkhags.id;
        ");
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_data');
    }
}