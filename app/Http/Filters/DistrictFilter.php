<?php
namespace App\Http\Filters;

use Illuminate\Http\Request;
use App\Filters\QueryFilters;
use App\Models\City;

class DistrictFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function city_slug( $s ) {
        $city = City::where('slug', $s)->first();
        if($city)
            return $this->builder->where('city_id', $city->id );
    }

    public function city_id( $s ) {
        return $this->builder->where('city_id', $s);
    }

}
