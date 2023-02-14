<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniformEmployee extends Model
{
    use HasFactory;

    protected $table = 'employeeuniform';

    protected $fillable = ['empId','id','officeId','designationID','shirt','pant','shoe','jacket','gumboot','raincoat'];
    public $timestamps = false;
}
