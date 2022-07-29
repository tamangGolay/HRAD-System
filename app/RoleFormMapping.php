<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class roleformmapping extends Model
{
    //
    protected $table='roleformmapping';

    protected $fillable = ['role_id','form_id','createdBy'];
    public $timestamps = false;
}
