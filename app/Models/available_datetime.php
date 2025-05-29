<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class available_datetime extends Model
{
    protected $table = 'available_datetime';
    protected $primaryKey = 'date_time';
    public $incrementing = false;
    protected $keyType = 'datetime';
    public $timestamps = false;
    protected $fillable = ['date_time'];
}
