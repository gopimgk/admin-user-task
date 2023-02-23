<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userdata extends Model
{
    use HasFactory;
    // protected $table='userdatas';
     protected $fillable = [
        'username',
        'Roll',
        'password',
    ];
}
