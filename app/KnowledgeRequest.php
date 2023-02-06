<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KnowledgeRequest extends Model
{
    //
    protected $table = 'knowledgerepository';

    protected $fillable = ['approveBy','id','createdBy','problem','solution','createdOn','status'];

    public $timestamps = false;


}
