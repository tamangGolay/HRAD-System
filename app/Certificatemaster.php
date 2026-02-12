<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificatemaster extends Model
{
    //
    protected $table = 'certificatemaster';

    protected $fillable = ['certificateId','eid','trainingId','cerType','issueDate'];

    public $timestamps = false;
  
}

