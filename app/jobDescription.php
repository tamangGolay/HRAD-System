<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jobDescription extends Model
{
    //
    protected $table = 'jobdescription';

    protected $fillable = ['id','empId','empName','jobDescription','status','dateExpired','officeId',
'createdBy','createdOn','approvedBy','approvedOn'];
    
    public $timestamps = false;
}
