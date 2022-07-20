<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    use HasFactory;

    protected $table = 'skillcategorymaster';

    protected $fillable = ['id','categoryName','status'];
    public $timestamps = false;
}
