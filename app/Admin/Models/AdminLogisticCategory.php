<?php

namespace App\Admin\Models;

use App\Models\LogisticCategory;
use App\Models\LogisticCategoryDescription;

class AdminLogisticCategory extends LogisticCategory
{
    protected static $getListTitleAdmin = null;
    protected static $getListCategoryGroupByParentAdmin = null;
    
    public static function getCategoryListAdmin(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        
        $tableDescription = (new LogisticCategoryDescription)->getTable();
        $tableCategory     = (new LogisticCategory)->getTable();

        $categoryList = (new LogisticCategory)
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $tableCategory . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());
        if ($keyword) {
            $categoryList = $categoryList->where(function ($sql) use ($tableDescription, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%');
            });
        }

        if(!empty($dataSearch['parent']) && $dataSearch['parent'] === 0)
        {
            $categoryList = $categoryList->where($tableCategory .'.parent', 0);
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $categoryList = $categoryList->orderBy($field, $sort_field);
        } else {
            $categoryList = $categoryList->orderBy('created_at', 'desc');
        }
        $categoryList->groupBy($tableCategory.'.id');

        $categoryList = $categoryList->paginate(20);

        return $categoryList;
    }

    public static function getListTitleAdmin()
    {
        $tableDescription = (new LogisticCategoryDescription)->getTable();
        $table = (new LogisticCategory)->getTable();
        
        if (self::$getListTitleAdmin === null) {
            self::$getListTitleAdmin = self::join($tableDescription, $tableDescription.'.category_id', $table.'.id')
            ->where('lang', sc_get_locale())
            ->pluck('name', 'id')
            ->toArray();
        }
        return self::$getListTitleAdmin;
        
    }

    /**
     * Get tree categories
     *
     * @param   [type]  $parent      [$parent description]
     * @param   [type]  &$tree       [&$tree description]
     * @param   [type]  $categories  [$categories description]
     * @param   [type]  &$st         [&$st description]
     *
     * @return  [type]               [return description]
     */
    public function getTreeCategoriesAdmin($parent = 0, &$tree = [], $categories = null, &$st = '')
    {
        $categories = $categories ?? $this->getListCategoryGroupByParentAdmin();
        $categoriesTitle =  $this->getListTitleAdmin();
        $tree = $tree ?? [];
        $lisCategory = $categories[$parent] ?? [];
        if ($lisCategory) {
            foreach ($lisCategory as $category) {
                $tree[$category['id']] = $st . ($categoriesTitle[$category['id']]??'');
                if (!empty($categories[$category['id']])) {
                    $st .= '--';
                    $this->getTreeCategoriesAdmin($category['id'], $tree, $categories, $st);
                    $st = '';
                }
            }
        }
        return $tree;
    }

    /**
     * Get array title category
     * user for admin
     *
     * @return  [type]  [return description]
     */
    public static function getListCategoryGroupByParentAdmin()
    {
        if (self::$getListCategoryGroupByParentAdmin === null) {
            self::$getListCategoryGroupByParentAdmin = self::select('id', 'parent')
            ->get()
            ->groupBy('parent')
            ->toArray();
        }
        return self::$getListCategoryGroupByParentAdmin;
    }

    /**
     * Insert data description
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function insertDescription(array $dataInsert)
    {
        return LogisticCategoryDescription::create($dataInsert);
    }
}
