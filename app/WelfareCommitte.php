<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WelfareCommitte extends Model
{
    //
    protected $table = 'welfarecommitte';

    protected $fillable = ['id',
    'memberEID','memberType','memberEmail'];
    
    public $timestamps = false;

    public function user()
    {
        // Assuming memberEID in WelfareCommitte table corresponds to id in users table
        return $this->belongsTo(User::class, 'memberEID', 'empId');
    }

}
