<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class conferencebook extends Model
{
    //
    protected $table = 'conferencerequest';

    protected $fillable = ['emp_id','name','meeting_name',
    'start_date','end_date','contact_number','org_unit_id','no_of_people','conference_id'];
}


