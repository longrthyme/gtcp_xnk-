<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOption extends Model
{
    public $timestamps = false;
    protected $table = 'shop_option';
    protected $guarded =[];

    protected static $listActiveAll = null;

    public static function getAllActive()
    {
        if (!self::$listActiveAll) {
            self::$listActiveAll = self::where('status', 1)->get();
        }
        return self::$listActiveAll;
    }

    public function categories()
    {
        return $this->hasMany(ShopOption::class, 'id', 'parent');
    }

    public function posts()
    {
        return $this->hasMany(ShopOption::class, 'parent', 'id');
    }
}
