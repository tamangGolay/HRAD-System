<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refund extends Model
{
    use HasFactory;
    //
    protected $table = 'wfrefund';

    protected $fillable = ['id','empId','refundDate','amount'];
    public $timestamps = false;
   
}
