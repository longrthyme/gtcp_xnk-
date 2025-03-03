<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageDayJoin extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'package_day_join';
    protected $guarded = [];

    public function getPackageDay()
    {
        return $this->hasOne(PackageDay::class, 'id', 'day_id');
    }

    public function getFinalPrice()
    {
        $package_day = $this->getPackageDay;
        $price = $this->price??0;
        if($this->used <= $package_day->qty)
        {
            if($this->promotion)
                $price = $this->promotion;
        }
        return $price;
    }
}
