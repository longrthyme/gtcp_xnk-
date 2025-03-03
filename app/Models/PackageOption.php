<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageOption extends Model
{
    public $timestamps = false;
    protected $table = 'package_option';
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
        return $this->hasMany(PackageOption::class, 'id', 'parent');
    }

    public function posts()
    {
        return $this->hasMany(PackageOption::class, 'parent', 'id');
    }
}
