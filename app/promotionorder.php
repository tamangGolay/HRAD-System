<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promotionorder extends Model
{
    //
    protected $table = 'viewpromotionorder';

    protected $fillable = ['empId', 'empName','oldDesignation','newDesignation',
    'officeName','officeId','officeAddress','officeDetails','newGrade','promotionDate','newBasic'];
    
    public $timestamps = false;
}

