<?php

namespace App\Admin\Models;

use App\Models\Page;
use App\Models\PageDescription;

class AdminPage extends Page
{
    /**
     * Get page detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getPageAdmin($id, $storeId = null)
    {
        $data = self::where('id', $id);
        if ($storeId) {
            $tablePageStore = (new ShopPageStore)->getTable();
            $tablePage = (new ShopPage)->getTable();
            $data = $data->leftJoin($tablePageStore, $tablePageStore . '.page_id', $tablePage . '.id');
            $data = $data->where($tablePageStore . '.store_id', $storeId);
        }
        $data = $data->first();
        return $data;
    }
    
    public function getListAdmin(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $category_id      = $dataSearch['category_id'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $tableDescription = (new PageDescription)->getTable();
        $tableProduct     = (new Page)->getTable();
        //Select field
        $dataSelect = $tableProduct.'.*, '.$tableDescription.'.name, '.$tableDescription.'.description, '.$tableDescription.'.content';

        $productList = (new Page)
            ->selectRaw($dataSelect)
            ->leftJoin($tableDescription, $tableDescription . '.post_id', $tableProduct . '.id');

        $productList = $productList
            ->where($tableDescription . '.lang', app()->getLocale());


        if ($keyword) {
            $productList = $productList->where(function ($sql) use ($tableDescription, $tableProduct, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%');
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

    /**
     * [getListPageAlias description]
     *
     * @param   [type]  $storeId  [$storeId description]
     *
     * @return  array             [return description]
     */
    public function getListPageAlias():array 
    {
        $arrReturn = [];
        $tablePage = $this->getTable();
        $tablePageStore = (new Page)->getTable();
        $data = $this;
        $arrReturn = $data->pluck('slug')->toArray();
        return $arrReturn;
    }

    /**
     * Create a new page
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function createPageAdmin(array $dataInsert)
    {
        return self::create($dataInsert);
    }

    /**
     * Insert data description
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function insertDescriptionAdmin(array $dataInsert)
    {
        return PageDescription::create($dataInsert);
    }
}
