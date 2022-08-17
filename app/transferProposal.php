<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transferProposal extends Model
{
    //
    protected $table = 'transferproposal';

    protected $fillable = ['id', 'requestId', 'empId ','proposedDate ', 'fromOffice ','toOffice', 'transferType','status'];

    public $timestamps = false;


}
