<?php

namespace App\Admin\Models;

use App\Models\Client;
use App\Models\ClientDescription;
use App\Models\ClientCategoryJoin;

class AdminClient extends Client
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
        return ClientDescription::create($dataInsert);
    }

    public function getListAdmin(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $category_id      = $dataSearch['category_id'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $tableDescription = (new ClientDescription)->getTable();
        $tablePTC         = (new ClientCategoryJoin)->getTable();
        $tableProduct     = (new Client)->getTable();
        //Select field
        $dataSelect = $tableProduct.'.*, '.$tableDescription.'.name, '.$tableDescription.'.description, '.$tableDescription.'.content';

        $productList = (new Client)
            ->selectRaw($dataSelect)
            ->leftJoin($tableDescription, $tableDescription . '.post_id', $tableProduct . '.id');

        if ($category_id) {
            $productList = $productList
                ->join($tablePTC, $tablePTC . '.post_id', $tableProduct . '.id')
                ->where($tablePTC . '.category_id', $category_id);
        }
        
        $productList = $productList
            ->where($tableDescription . '.lang', app()->getLocale());


        if ($keyword) {
            $productList = $productList->where(function ($sql) use ($tableDescription, $tableProduct, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%')->orwhere($tableProduct . '.id', $keyword);
            });
        }
        $productList->groupBy($tableProduct.'.id');

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
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
