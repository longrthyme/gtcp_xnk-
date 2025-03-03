<?php


namespace App\Http\Filters;
use App\Models\Acreage;
use App\Models\Category;
use App\Models\PriceConfig;
use Illuminate\Http\Request;
use App\Filters\QueryFilters;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;

class ProductFilter extends QueryFilters
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
            return $this->builder->where('price','>=',$price->from)->where('price','<=',$price->to);
    }

    public function acreage($s){
        $acreage = Acreage::where('slug',$s)->first();
        if($acreage){
            return $this->builder->where('acreage','>=',$acreage->from)->where('acreage','<=',$acreage->to);
        }
    }

    public function direction($s){
        return $this->builder->where('direction',$s);
    }

    public function juridical($s){
        return $this->builder->where('juridical',$s);
    }

    public function district_id($s){
        return $this->builder->where('district_id',$s);
    }

    public function keyword($s){
        return $this->builder->where('title','like','%'.$s.'%');
    }

    public function news_type($s){
        return $this->builder->where('news_type', $s );
    }

    public function user_type($s){
        return $this->builder->where('user_type', $s );
    }

    public function category_slug($s){
        if( $s == 'tat-ca-nha-dat-thue'){
            $categoryIds = Category::where('news_type', 'cho_thue' )->pluck('id')->toArray();
            return $this->builder->whereIn('category_id', $categoryIds );
        }

        if( $s == 'tat-ca-nha-dat-ban'){
            $categoryIds = Category::where('news_type', 'mua_ban' )->pluck('id')->toArray();
            return $this->builder->whereIn('category_id', $categoryIds );
        }


        if( $s ){
            $category = Category::where('category_slug', $s)->first();
            if($category)
                return $this->builder->where('category_id', $category->id );
        }

    }

    public function province($s){
        $province = Province::where('slug', $s)->first();
        if($province){
            return $this->builder->whereHas('getInfo', function($query) use($province){
                return $query->where('province_id', $province->id);
            });
        }
        // return $this->builder->where('provice_id',$city->id);
    }

    public function district($s){
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
