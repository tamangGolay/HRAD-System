<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //
    protected $table = 'certificateverifier';

    protected $fillable = ['id','certificateId','issuedFor','issueDate','receivedBy','createdOn','createdBy','status'];

    public $timestamps = false;

  
}

