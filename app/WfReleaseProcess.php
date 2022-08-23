<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WfReleaseProcess extends Model
{
    //
    protected $table = 'wfreleaseprocess';

    protected $fillable = [ 'id','empId','requestDate','amount','deathOf','reason','status','createdBy','member1Id','member1Action','member1ActionDate','member2id','member2Action','member2ActionDate','chairAction','chairEmpId','chairActionDate'];
    public $timestamps = false;

}

