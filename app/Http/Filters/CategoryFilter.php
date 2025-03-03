<?php
namespace App\Http\Filters;

use Illuminate\Http\Request;
use App\Filters\QueryFilters;

class CategoryFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function category_slug( $s ) {
        return $this->builder->where('category_slug', $s );
    }

    public function news_type( $s ) {
        return $this->builder->where('news_type', $s);
    }

}
