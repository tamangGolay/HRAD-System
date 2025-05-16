<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vehiclerequest extends Model
{
    //
    protected $table = 'vehiclerequest';




    protected $fillable = ['id','emp_id','email','name','start_date','end_date','office_id','date_of_requisition','vehicleId','purpose','places_to_visit','role'];

   


}
