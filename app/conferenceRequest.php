<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class conferencerequest extends Model
{
    protected $table = 'conferencerequest';

    protected $fillable = ['emp_id','name','meeting_name','conference_id',
    'start_date','end_date','no_of_people','org_unit_id','contact_number','default'];



     public $timestamps = false;
}
