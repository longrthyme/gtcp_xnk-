<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUpgrade extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'user_upgrade';
    protected $guarded = [];

    
}
