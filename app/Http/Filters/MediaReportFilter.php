<?php
namespace App\Http\Filters;

use Illuminate\Http\Request;
use App\Filters\QueryFilters;


class MediaReportFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function date_start( $s ) {
        $this->builder->whereDate('date','>=', $s );
    }

    public function date_end( $s ) {
        $this->builder->whereDate('date','<=', $s );
    }

    public function app_ad_id( $s ) {
        return $this->builder->where('app_ad_id', $s );
    }

    public function format( $s ) {
        return $this->builder->where('format', $s );
    }

    // $s Y//m/d-Y-m-d
    public function created_at( $s ){
        $arrTime = explode('-', $s );
        $this->builder->whereDate('created_at','>=', str_replace( '/','-',  $arrTime[0]  ) );
        $this->builder->whereDate('created_at','<=', str_replace( '/','-',  $arrTime[1] ) );
    }

}