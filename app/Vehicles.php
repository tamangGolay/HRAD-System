<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    //
    protected $table = 'vehicledetails';

    protected $fillable = ['vehicle_name',
    'vehicle_number','status'];
    
    public $timestamps = false;
}
