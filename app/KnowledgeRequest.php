<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Knowledgerequest extends Model
{
    //
    protected $table = 'knowledgerepository';

    protected $fillable = ['approveBy','createdBy','problem','solution','createdOn','status'];

    public $timestamps = false;


}
