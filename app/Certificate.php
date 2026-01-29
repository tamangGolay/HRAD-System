<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //
    protected $table = 'certificateverifier';

    protected $fillable = ['id','certificateTypeId','certificateId','issuedFor','issueTo','issueDate','cidNo','venue','startDate','endDate','receivedBy','createdOn','createdBy','status'];

    public $timestamps = false;
  
}

