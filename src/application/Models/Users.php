<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $fillable = ['year', 'username','password','name','lastname','allocation','permission'];
}