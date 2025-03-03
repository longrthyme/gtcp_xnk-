<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ShopCategoryDescription;

use App\Models\ShopProductCategory;
use App\Models\ShopProduct;

class ShopCategory extends Model
{
    protected $table = 'shop_category';
    protected  $guarded = []; // array category id

    public function descriptions()
    {
        return $this->hasMany(ShopCategoryDescription::class, 'category_id', 'id');
    }

    //Function get text description
    public function getText()
    {
        return $this->descriptions()->where('lang', sc_get_locale())->first();
    }

    /**
     * [getUrl description]
     * @return [type] [description]
     */
    public function getUrl($slug_parent = null, $post_type = '')
    {
        $parameter = array_filter(['slug' => $this->slug, 'post_type' => $post_type]);
        if($slug_parent != null)
        {
            $parameter = array_filter(['slug' => $slug_parent, 'slug_sub' => $this->slug, 'post_type' => $post_type]);
            return sc_route('product', $parameter);
        }

        return sc_route('product', $parameter);
    }

    public function getPriceConfig()
    {
        $category_parent = $this->getParentFirst($this);
        if($category_parent && $category_parent->id == 5)
            $price_config = (new \App\Model\PricePurchaseConfig)->getList([]);
        else
            $price_config = (new \App\Model\PriceConfig)->getList([]);
        
        return $price_config;
    }
    
    public function products(){
        return $this->belongsToMany(ShopProduct::class, 'shop_product_category', 'category_id', 'product_id')->orderByDesc('shop_product.created_at');
    }
    

    public function children() {
        return $this->hasMany(ShopCategory::class, 'parent', 'id')->where('status', 1)->orderByDesc('created_at');
    }
    public function getParent() {
        return $this->hasOne(ShopCategory::class, 'id', 'parent');
    }
    public function getParentFirst($category_parent) {

        if($category_parent && $category_parent->parent)
        {
            $category = ShopCategory::find($category_parent->parent);

            $category_parent = $this->getParentFirst($category);
        }
        return $category_parent;
    }
    public function getParentList($parent = 0, $parent_arr = [])
    {
        if($parent)
        {
            $category = (new ShopCategory)->getDetail($parent);
            $parent_arr[] = $category;
            if($category->parent)
            {
                return $this->getParentList($category->parent, $parent_arr);
            }
            else
                return $parent_arr;
        }
    }

    public function getTopParent($category) {
        if($category && $category->parent === null) {
            return $category->name;
        }

        if($category->parent)
            return $this->getTopParent((new ShopCategory)->getDetail($category->parent));

        // Will return Electronics

    }

    public function getListData()
    {
        $tableDescription = (new ShopCategoryDescription)->getTable();
        $tableCategory     = (new ShopCategory)->getTable();

        $categoryList = (new ShopCategory)
            ->leftJoin($tableDescription, $tableDescription . '.category_id', $tableCategory . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        return $categoryList;
    }

    public function getList(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $parent          = isset($dataSearch['parent']) ? $dataSearch['parent'] : '';
        $getAllActive          = $dataSearch['getAllActive'] ?? 0; //get all active


        $tableDescription = (new ShopCategoryDescription)->getTable();
        $tableCategory     = (new ShopCategory)->getTable();
        $categoryList = $this->getListData();
        
        if ($keyword) {
            $categoryList = $categoryList->where(function ($sql) use ($tableDescription, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%');
            });
        }

        if($parent !== '')
        {
            $categoryList = $categoryList->where('parent', $parent);
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $categoryList = $categoryList->orderBy($field, $sort_field);
        } else {
            $categoryList = $categoryList->orderBy('created_at', 'desc');
        }
        $categoryList->groupBy($tableCategory.'.id');

        $categoryList = $categoryList->where('status', 1);
        $categoryList = $categoryList->paginate(20);

        return $categoryList;
    }

    public function getDetail($key = null, $type = null, $checkActive = 1)
    {
        if (empty($key)) {
            return null;
        }
        
        $tableDescription = (new ShopCategoryDescription)->getTable();

        $dataSelect = $this->getTable().'.*, '.$tableDescription.'.*';

        $post = $this->leftJoin($tableDescription, $tableDescription . '.category_id', $this->getTable() . '.id');
        
        $post = $post->where($tableDescription . '.lang', sc_get_locale());

        if (empty($type)) {
            $post = $post->where($this->getTable().'.id', $key);
        } 
        elseif ($type == 'slug') {
            $post = $post->where($this->getTable().'.slug', $key);
        } 
        else {
            return null;
        }

        if ($checkActive) 
        {
            $post = $post->where($this->getTable() .'.status', 1);
        }
        $post = $post->selectRaw($dataSelect);

        $post = $post->first();
        return $post;
    }
}
