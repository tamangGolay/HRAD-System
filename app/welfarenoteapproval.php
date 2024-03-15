<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class welfarenoteapproval extends Model
{
    //
    protected $table = 'welfarenoteapproval';

    protected $fillable = ['welfareId','modifier','modiType','remarks'];

    public $timestamps = false;


}
