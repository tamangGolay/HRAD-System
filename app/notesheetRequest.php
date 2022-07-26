<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notesheetrequest extends Model
{
    //
    protected $table = 'notesheet';

    protected $fillable = ['createdBy','topic','justification','status'];

    public $timestamps = false;


}
