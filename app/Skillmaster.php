<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skillmaster extends Model
{
    //
    protected $table = 'skillmaster';

    protected $fillable = ['id','skillName','subCatId','status'];
    public $timestamps = false;
}  
