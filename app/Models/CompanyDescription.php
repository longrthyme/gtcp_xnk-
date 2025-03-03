<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDescription extends Model
{
    public $timestamps = false;
    protected $table = 'company_descriptions';
    protected $guarded =[];
}
