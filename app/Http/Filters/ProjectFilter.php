<?php


namespace App\Http\Filters;
use App\Models\Acreage;
use App\Models\Category;
use App\Models\PriceConfig;
use Illuminate\Http\Request;
use App\Filters\QueryFilters;
use App\Models\City;
use App\Models\District;
use App\Models\Ward;

class ProjectFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function price($s){
        $price = PriceConfig::where('slug',$s)->first();
        if($price)
            return $this->builder->where('gia','>=',$price->from)->where('gia','<=',$price->to);
    }

    public function keyword($s){
        return $this->builder->orWhere('title','like','%'.$s.'%');
    }

    public function category_id($s){
        // return $this->builder->where('category_id', 'LIKE', '%"id":'.$s.'%'  );
        return $this->builder->where('category_id', $s );
    }

    public function category_slug($s){
        $cat = Category::where('id', $s)->first();
        if( $cat ) return $this->builder->where('category_id', $cat->id );
        // return $this->builder->where('category_id', 'LIKE', '%"id":'.$s.'%'  );

    }



    public function status($s){
        return $this->builder->where('status', $s );
    }

    public function district_id($s){
        return $this->builder->where('district_id',$s);
    }


    public function city_slug($s){
        $city = City::where('slug', $s)->first();
        if($city)
        return $this->builder->where('city_id',$city->id);
    }

    public function district_slug($s){
        $d = District::where('slug', $s)->first();
        if($d)
        return $this->builder->where('district_id', $d->id );
    }

    public function ward_slug($s){
        $d = Ward::where('slug', $s)->first();
        if($d)
            return $this->builder->where('ward_id', $d->id );
    }



}
