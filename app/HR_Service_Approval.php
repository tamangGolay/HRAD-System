<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HR_Service_Approval extends Model
{
    //
    protected $table = 'hrserviceapproval';

    protected $fillable = ['remarks','noteId','modifier','modiType'];
    
    public $timestamps = false;


}
