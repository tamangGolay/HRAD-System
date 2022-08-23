<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transferHistory extends Model
{
    //
    protected $table = 'transferhistory';

    protected $fillable = ['id','proposalId','empId','transferDate','transferFrom','transferTo','reportToOffice','transferType','transferBenefit','orderReleasedBy','orderReleasedOn','relievedBy','relievedOn','joinedOn','joiningAcceptedBy','joiningAcceptedOn','status'];

    public $timestamps = false;


}
