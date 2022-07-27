<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notesheetapprove extends Model
{
    //
    protected $table = 'noteapproval';

    protected $fillable = ['remarks','noteId','modifier'];

    public $timestamps = false;


}
