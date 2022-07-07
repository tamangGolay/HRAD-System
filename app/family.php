<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class family extends Model
{
    //
    protected $table = 'familydetailsmaster';

    protected $fillable = ['personalNo', 'relativeName','dob','gender','relation'];
    
    public $timestamps = false;
}
