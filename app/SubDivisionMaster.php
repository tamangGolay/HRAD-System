<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubDivisionMaster extends Model
{
    protected $table = 'subdivisionmaster';

   
    protected $fillable = ['id','subDivnameShort','subDivnameLong','subDivhead','subDivreportsTodivision','subDivreportsTodepartment','subDivreportsToservice','subDivreportsTocompany','subDivreportsToEmp','status'];

      public $timestamps = false;
}
