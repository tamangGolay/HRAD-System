<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uniform extends Model
{
    use HasFactory;

    protected $table = 'officeuniform';

    protected $fillable = ['org_unit_id','uniform_id','S','M','L','XL','2XL','3XL','4XL','5XL','6XL','dzongkhag'];
    public $timestamps = false;
}
