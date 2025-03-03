<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Slider;
use App\Models\SliderDescription;

class AdminSlider extends Slider
{
    /**
     * Insert data description
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function insertDescription(array $dataInsert)
    {
        return SliderDescription::create($dataInsert);
    }
    
    public function getListAdmin(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $category_id      = $dataSearch['category_id'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $slider_id          = $dataSearch['slider_id'] ?? '';
        $tableDescription = (new SliderDescription)->getTable();
        $tableProduct     = (new Slider)->getTable();
        //Select field
        $dataSelect = $tableProduct.'.*, '.$tableDescription.'.name, '.$tableDescription.'.description, '.$tableDescription.'.content';

        $productList = (new Slider)
            ->selectRaw($dataSelect)
            ->leftJoin($tableDescription, $tableDescription . '.post_id', $tableProduct . '.id');

        if ($slider_id !== '') {
            $productList = $productList->where($tableProduct . '.slider_id', $slider_id);
        }
        
        $productList = $productList
            ->where($tableDescription . '.lang', app()->getLocale());


        if ($keyword) {
            $productList = $productList->where(function ($sql) use ($tableDescription, $tableProduct, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%');
            });
        }
        $productList->groupBy($tableProduct.'.id');

        if ($sort_order) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $productList = $productList->orderBy($field, $sort_field);
        } else {
            $productList = $productList->orderBy($tableProduct.'.created_at', 'desc');
        }
        $productList = $productList->paginate(20);

        return $productList;
    }
}
