<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainingmaster extends Model
{
    //
    // protected $table = 'trainingmaster';

    // protected $fillable = ['trainingId','startDate','endDate','place','signer1Name','signer2Name','signer1Designation','signer2Designation','institute','trainingName'];

    // public $timestamps = false;

    protected $table = 'trainingmaster';

    protected $primaryKey = 'trainingId';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'trainingId',
        'trainingName',
        'startDate',
        'endDate',
        'institute',
        'place',
        'signer1Name',
        'signer1Designation',
        'signer2Name',
        'signer2Designation'
    ];
    
  
}

