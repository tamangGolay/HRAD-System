<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notesheetrequest extends Model
{
    //
    protected $table = 'notesheet';

    protected $fillable = ['id','createdBy','topic','justification','officeId','createdOn','status','approverLevel'];

    public $timestamps = false;


}
