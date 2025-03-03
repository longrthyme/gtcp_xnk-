<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public $timestamps = false;
    protected $table = 'user_type';
    protected $guarded =[];

    private static $getListActive      = null;

    public static function getListActive()
    {
        if (self::$getListActive === null) {
            self::$getListActive = self::where('status', 1)->orderby('id', 'asc')
                ->get()
                ->keyBy('id');
        }
        return self::$getListActive;
    }
}
