<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractDetailMaster extends Model
{
    protected $table = 'contractdetailsmaster';

   
    protected $fillable = ['id','personalNo','startDate','endDate','termNo','status'];

     public $timestamps = false;
}
