<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class roleusermappings extends Model
{
    //
    protected $table="userrolemapping";

    protected $fillable = ['user_id','role_id','created_by','updated_at'];
    // const updated_at = null;
    public $timestamps = false;
}
