<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promotionRequest extends Model
{
    //
    protected $table = 'promotionduelist';

    protected $fillable = ['id ','promotionYear','promotionMonth','empId ','fromGrade','toGrade','oldBasic','newBasic','office','status','rejectReason'];

    public $timestamps = false;


}
