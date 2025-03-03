<?php
namespace App\Libraries\ShoppingCart;

use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    protected $primaryKey = null;
    public $incrementing  = false;
    public $table = 'shop_shoppingcart';
    protected $guarded = [];
}
