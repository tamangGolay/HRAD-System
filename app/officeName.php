<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class officename extends Model
{
    //
    protected $table = 'officename';

    protected $fillable = ['id','shortOfficeName',
    'longOfficeName','status','created_at','updated_at'];
    
    public $timestamps = false;
}
