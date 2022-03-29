<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniformEmployee extends Model
{
    use HasFactory;

    protected $table = 'employeeuniform';

    protected $fillable = ['emp_id','name','contact_number','org_unit_id','shirt','pant','shoe','jacket','jumboot','raincoat'];
    public $timestamps = false;
}
