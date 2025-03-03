<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopProductContact extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'shop_product_contact';
    protected $primaryKey = 'id';
    protected  $guarded = [];

    function getCustomerUrl()
    {
        return sc_route('customer.customer_post', ['id' => $this->user_id]);
    }

    function getPhone()
    {
        if(auth()->check())
            return $this->phone;
        return str_replace( substr($this->phone, -5), '*****', $this->phone );
    }
}
