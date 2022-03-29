<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class status extends Model
{

    // const STATUS_COLOR = [
    //     'Rejected'  => '#FFFF99',
    //     '4'   => '#90EE90',
    // ];
    //
    protected $table = 'vehiclestatus';

  

   
       

    protected $fillable = ['ids','action'];

     public $timestamps = false;
}
