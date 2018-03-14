<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['user', 'course', 'grade'];
}