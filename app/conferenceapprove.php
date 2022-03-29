<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class conferenceapprove extends Model
{
    protected $table = 'conferencerequest';
    protected $fillable = ['status'];

     public $timestamps = false;
}
