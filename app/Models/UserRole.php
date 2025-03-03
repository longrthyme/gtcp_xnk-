<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $timestamps = false;
    protected $table = 'user_roles';
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
