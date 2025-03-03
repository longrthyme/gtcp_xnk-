<?php
namespace App\Http\Filters;

use Illuminate\Http\Request;
use App\Filters\QueryFilters;
use App\Models\District;

class WardFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function district_slug( $s ) {
        $district = District::where('slug', $s)->first();
        if($district)
            return $this->builder->where('district_id', $district->id );
    }

    public function district_id( $s ) {
        return $this->builder->where('district_id', $s);
    }

}
