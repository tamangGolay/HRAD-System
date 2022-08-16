<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transferRequest extends Model
{
    //
    protected $table = 'transferrequest';

    protected $fillable = ['id', 'requestDate', 'fromOffice ','toOffice ', 'requestToEmp ','reason', 'createdBy','createdOn','status'];

    public $timestamps = false;


}
