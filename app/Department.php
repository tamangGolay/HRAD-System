<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $table = 'departmentmaster';

    protected $fillable = ['id','deptNameShort','deptNameLong','deptHead','deptReportsToService','deptReportsToCompany','status'];
    
    public $timestamps = false;
}  
