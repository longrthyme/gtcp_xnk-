<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOption extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'user_option';
    protected $guarded =[];

    public function getOption()
    {
        return $this->hasOne(ShopOption::class, 'id', 'option_id');
    }
}
