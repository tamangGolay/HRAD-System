<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    protected $connection = 'mysql2';   // ✅ force mysql2
    protected $table = 'holidays';      // ✅ table name
    protected $fillable = ['holiday_date', 'holiday_name', 'status'];
    public $timestamps = false; 
}

