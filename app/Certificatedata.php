<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificatedata extends Model
{
    //
    protected $table = 'CertificateData';

    protected $fillable = ['certificateId', 'cerType', 'title', 'name', 'CID', 'EID', 'Office', 'designation', 'trainingName', 'startDate', 'endDate', 'instituteName', 'place', 'signer1Name', 'signer1Designation', 'signer2Name', 'signer2Designation'];

    public $timestamps = false;
  
}

