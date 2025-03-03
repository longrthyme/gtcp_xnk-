<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockContent extends Model
{
    public $timestamps = false;
    protected $table = 'shop_store_block';
    protected $fillable = [
        'name',
        'text',
        'position',
        'page',
        'description',
        'sort',
        'status',
        'image',
    ];
    private static $getLayout = null;

    public static  function getLayout()
    {
        if (self::$getLayout === null) {
            self::$getLayout = self::where('status', 1)
                ->orderBy('sort', 'asc')
                ->get()
                ->groupBy('position');
        }
        return self::$getLayout;
    }
}
