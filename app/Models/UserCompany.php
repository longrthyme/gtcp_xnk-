<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'user_company';
    protected $guarded = [];
}
