<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public $timestamps = false;
    protected $table = 'wishlist';
    protected $fillable =[
        'product_id',
        'user_id'
    ];

    public function product(){
        return $this->hasOne(ShopProduct::class, 'id', 'product_id')->orderByDesc('shop_product.created_at');
    }
}
