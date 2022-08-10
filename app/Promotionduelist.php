<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotionduelist extends Model
{
    //
    protected $table = 'promotionduelist';

    protected $fillable = [ 'id','empId','fromGrade','toGrade'
    ,'promotionMonth','promotionYear'
    ,'oldBasic','newBasic','office'];
    public $timestamps = false;

}



 