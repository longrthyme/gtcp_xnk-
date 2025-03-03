<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopPaymentMethod extends Model
{
    public $timestamps = true;
    // protected $table = 'shop_payment_method';
    protected $guarded =[];

    protected static $listActiveAll = null;

    public static function getAllActive()
    {
        if (!self::$listActiveAll) {
            self::$listActiveAll = self::where('status', 1)->get();
        }
        return self::$listActiveAll;
    }


    public function method()
    {
        return $this->hasMany(ShopPaymentMethodItem::class, 'method_id', 'id');
    }

    public function setting()
    {
        return $this->hasMany(ShopPaymentMethodSetting::class, 'method_id', 'id');
    }
}
