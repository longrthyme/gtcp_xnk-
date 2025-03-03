<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategoryJoin extends Model
{
    public $timestamps = false;
    protected $table = 'post_category_join';
    public $incrementing = false;
    protected $guarded =[];
}
