<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JacketSize extends Model
{
    use HasFactory;

    protected $table = 'jacketmaster';

    protected $fillable = ['jSId','sizeName','usUkSize','euSize','gender','status'];
    public $timestamps = false;
}
