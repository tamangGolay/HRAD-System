<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vehicleapprove extends Model
{
    protected $table = 'vehiclerequest';
    protected $fillable = ['status','supervisor'];

     public $timestamps = false;
}
