<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgUnit extends Model
{
    protected $table = 'orgunit';
    protected $fillable = ['id','code','description','parent_id'];

     public $timestamps = false;
}

