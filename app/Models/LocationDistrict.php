<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationDistrict extends Model
{
    public $timestamps = false;
    protected $table = 'location_district';
    protected $fillable =[
        'name',
        'slug',
        'type',
        'province_id'
    ];


    public function ward()
    {
        return $this->hasMany(LocationWard::class, 'district_id');
    }
}
