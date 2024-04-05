<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class welfareRequest extends Model
{
    //
    protected $table = 'welfarenote';

    protected $fillable = ['id','createdBy','topic','empID','reltionToEmp','justification','createdOn','createdBy','status'];

    public $timestamps = false;

  
}

