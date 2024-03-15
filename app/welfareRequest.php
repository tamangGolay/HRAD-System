<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class welfareRequest extends Model
{
    //
    protected $table = 'welfarenote';

    protected $fillable = ['id','createdBy','topic','justification','createdOn','createdBy','status'];

    public $timestamps = false;

}
