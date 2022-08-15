<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionHistoryMaster extends Model
{
    //
    protected $table = 'promotionhistorymaster';

    protected $fillable = [ 'id','empId','promotionDate','gradeTo'
    ,'oldDesignation','newDesignation'
    ,'newBasicPay','office'];
    public $timestamps = false;

}



 