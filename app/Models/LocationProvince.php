<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationProvince extends Model
{
    public $timestamps = false;
    protected $table = 'location_province';

    protected $fillable =[
        'name',
        'slug',
        'code',
    ];

    public function district()
    {
        return $this->hasMany(LocationDistrict::class, 'province_id');
    }
}
