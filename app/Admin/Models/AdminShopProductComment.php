<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminShopProductComment extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'admin_shop_product_comment';
    protected $guarded =[];

    public function getAdmin()
    {
        return $this->hasOne(\App\Models\Admin::class, 'id', 'admin_id');
    }
}
