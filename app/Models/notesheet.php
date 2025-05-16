<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notesheet extends Model
{

   protected $table = 'notesheet';

   public $fillable = 
[

   'createdBy',
   'id',
   'topic',
   'justification',
   'status',
   ];
}
