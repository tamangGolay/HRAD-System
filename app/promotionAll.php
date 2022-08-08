<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promotionAll extends Model
{
    //
    protected $table = 'promotionall';

    protected $fillable = [ 'id','empId','grade','gradeCeiling','yearsToPromote','doJoining','doLastPromotion','promotionDueDate','modificationReason'];
    public $timestamps = false;

}



 