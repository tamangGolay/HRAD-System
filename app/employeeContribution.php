<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employeeContribution extends Model
{
    //
    protected $table = 'wfcontribution';

    protected $fillable = ['empId','contributionDate','year','month','amount'];
    
}  
