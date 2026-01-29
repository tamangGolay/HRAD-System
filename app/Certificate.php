<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //
    protected $table = 'certificateverifier';

    protected $fillable = ['id','certificatetypeid','certificateId','issuedFor','issueDate','receivedBy','cidNo','createdOn','createdBy','status'];

    public $timestamps = false;

  
}

