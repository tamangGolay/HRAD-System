<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Duelist extends Model
{
    //
    protected $table = 'incrementduelist';

    protected $fillable = ['incrementYear', 'incrementMonth','empId','oldBasic','yearlyIncrement','newBasic','createdOn','status'];    
    public $timestamps = false;
}
