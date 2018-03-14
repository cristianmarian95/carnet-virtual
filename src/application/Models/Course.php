<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['sid', 'name', 'credits', 'year', 'sem'];
}