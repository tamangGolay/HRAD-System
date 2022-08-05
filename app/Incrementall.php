<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incrementall extends Model
{
    use HasFactory;

    protected $table = 'incrementall';

    protected $fillable = ['id','empId','lastIncrementDate','incrementDueDate','incrementCycle','modificationReason'];
    public $timestamps = false;
}
