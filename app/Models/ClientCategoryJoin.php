<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientCategoryJoin extends Model
{
    public $timestamps = false;
    protected $table = 'client_category_join';
    public $incrementing = false;
    protected $guarded =[];
}
