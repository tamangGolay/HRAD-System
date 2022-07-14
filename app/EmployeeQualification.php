<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeQualification extends Model
{
    //
    protected $table = 'employeequalificationmaster';

    protected $fillable = ['personalNo','qualificationId','yearCompleted','status'];
    
    public $timestamps = false;
}
