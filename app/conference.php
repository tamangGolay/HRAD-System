<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class conference extends Model
{
    protected $table = 'conference';
    protected $fillable = ['Conference_Name','capacity','location','range_id','status_c'];

     public $timestamps = false;
}
