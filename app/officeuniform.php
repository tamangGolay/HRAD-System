<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class officeuniform extends Model
{
    use HasFactory;
    protected $table = 'officeuniform';

    protected $fillable = ['org_unit_id','shirt_id','pant_id','jacket_id','raincoat_id',
                           'S','M','L','XL','2XL','3XL','4XL','5XL','6XL'];
    public $timestamps = false;
    
}
