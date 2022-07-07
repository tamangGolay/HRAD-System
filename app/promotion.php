<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promotion extends Model
{
    //
    protected $table = 'promotionhistorymaster';

    protected $fillable = ['personalNo', 'promotionDate','gradeFrom','gradeTo','nextDue','remarks'];
    
    public $timestamps = false;
}

