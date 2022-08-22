<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pay extends Model
{
    //
    protected $table = 'jobdescription';

    protected $fillable = ['id','empId', 'jobDescription','status','dateExpired',
'createdBy','createdOn','approvedBy','approvedOn'];
    
    public $timestamps = false;
}
