<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['title', 'text', 'descs', 'quality', 'price', 'url'];
}
