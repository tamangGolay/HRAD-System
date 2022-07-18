<?php

namespace App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RainCoatSize extends Model
{
  use HasFactory;

    //
    protected $table = 'raincoatsize';

    protected $fillable = ['id','sizeName','shouldersCm','chestCm','waistCm','bottomCm','lengthCm','sleeveCm','gender','status'];
    public $timestamps = false;

   }  


