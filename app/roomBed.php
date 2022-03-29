<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class roombed extends Model
{
    //
    protected $table = 'roombed';

   
       

    protected $fillable = ['guest_house_id','org_unit_id','emp_id','employeeId','dzongkhag','gender','name','roomdetails_id','check_in','check_out','email','rate'];

     public $timestamps = false;
}
