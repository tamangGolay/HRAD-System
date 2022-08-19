<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transferHistory extends Model
{
    //
    protected $table = 'transferhistory';

    protected $fillable = ['id','proposalId','empId','transferDate','transferFrom','transferTo','transferType','transferBenefit','orderReleasedBy','orderReleasedOn','relievedBy','relievedOn','joinedOn','joiningAcceptedBy','joiningAcceptedOn','status'];

    public $timestamps = false;


}
