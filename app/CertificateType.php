<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateType extends Model
{
    //
    protected $table = 'certificatetype';

    protected $fillable = ['id','nameofcertificate','status'];

     public $timestamps = false;
}
