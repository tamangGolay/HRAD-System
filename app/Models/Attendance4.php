<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance4 extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';    
    protected $table = 'attendance_april';

    // Specify the fields that are mass-assignable
    protected $fillable = [
        'user_id',
        'empName',
        'office_id',
        'check_in_time',
        'check_in_latitude',
        'check_in_longitude',
        'check_in_address',
        'checkin_status',
        'remarks_supervisor',
        'date',
        'check_out_latitude',
        'check_out_longitude',
        'check_out_time',
        'check_out_address',
        
    ];

    // Use the Carbon library for timestamps if needed (Carbon is included in Laravel by default)
    protected $dates = ['timestamp'];

    // Disable the default incrementing of the ID field if you are using a non-auto-incrementing primary key
    public $incrementing = true;

    public $timestamps = false;
}
