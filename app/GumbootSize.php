<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GumbootSize extends Model
{
    use HasFactory;

    protected $table = 'gumboot';

    protected $fillable = ['id','eUSize','uSSize','uKSize','innerSLengthCm','bootLengthCm','innerSWidthCm','bootWidthCm','bootOpeningCm','status'];
    public $timestamps = false;
}
