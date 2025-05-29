<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class scheduling extends Model
{
    protected $table = 'scheduling';
    public $timestamps = false;
    protected $guarded = ['*'];
}
