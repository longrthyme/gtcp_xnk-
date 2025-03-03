<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Package;

class PaymentRequest extends Model
{
    public $timestamps = true;
    protected $table = 'payment_request';
    protected $guarded =[];

    /**
     * @var array
     */
    protected $appends = [
        'package'
    ];

    public function getPackageAttribute()
    {
        $package_id = $this->package_id;
        $package = Package::find($package_id);
        if($package)
            return $package->toArray();
        else
            return null;
    }

    public function getProduct()
    {
        return $this->hasOne(ShopProduct::class, 'id', 'package_id');
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function statusText()
    {
        $status = 'Chưa thanh toán';
        if($this->status == 1)
            $status = 'Đã thanh toán';

        return $status;

    }
}
