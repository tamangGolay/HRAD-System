<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTwice extends Model
{
    //
    protected $table = 'employee4twimc';

    protected $fillable = ['empId','empName','cIdNo','designation','grade','office',
'employmentType','superNumber','superEmailId'];
    public $timestamps = false;
}  
