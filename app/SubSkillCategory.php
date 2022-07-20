<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSkillCategory extends Model
{
    use HasFactory;

    protected $table = 'skillsubcategory';

    protected $fillable = ['id','subCatName','catId','status'];
    public $timestamps = false;
}
