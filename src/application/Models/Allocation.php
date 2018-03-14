<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    protected $fillable = ['college', 'section'];
}