<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSkillMap extends Model
{
    use HasFactory;

    protected $table = 'employeeskillmap';

    protected $fillable = ['id','pNo','skillId','obtainedOn','expiryDate','status'];
    public $timestamps = false;
}
