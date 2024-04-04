<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaptopRelease extends Model
{
    use HasFactory;
    
    protected $table = 'laptopdetails';

    protected $fillable = ['id','empId','remarks','releasedate'];
    public $timestamps = false;
   
}
