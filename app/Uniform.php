<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uniform extends Model
{
    use HasFactory;

    protected $table = 'officeuniform';

    protected $fillable = ['org_unit_id','uniform_id','S','M','L','XL','Size_2XL','Size_3XL','Size_4XL','Size_5XL','Size_6XL','shoe_3','shoe_4','shoe_5','shoe_6','shoe_7','shoe_8','shoe_9','shoe_10','shoe_11','shoe_12','shoe_13','shoe_14','shoe_15','dzongkhag'];
    public $timestamps = false;
}
