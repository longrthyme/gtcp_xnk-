<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $timestamps = false;
    protected $table = 'packages';
    protected $guarded =[];

    private static $getListActive      = null;

    public static function getListActive()
    {
        if (self::$getListActive === null) {
            self::$getListActive = self::where('status', 1)->orderby('sort', 'asc')
                ->get()
                ->keyBy('code');
        }
        return self::$getListActive;
    }

    public function getUrl($day_id='')
    {
        return route('purchase.detail', ['id' => $this->id, 'day' => $day_id]);
    }

    public function options()
    {
        return $this->hasMany(PackageOptionJoin::class, 'package_id', 'id');
    }
    function getOptions()
    {
        return $this->options()->pluck('option_id')->toArray();
    }

    public function packageDays()
    {
        return $this->hasMany(PackageDayJoin::class, 'package_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($post) {
                $post->options()->detach();
            }
        );
    }
}
