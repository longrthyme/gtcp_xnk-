<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopVideo extends Model
{
    public $timestamps = true;
    protected $guarded = [];

    public function categories(){
        return $this->belongsToMany(ShopVideo::class, 'shop_product_category', 'product_id', 'category_id');
    }

    public function description()
    {
        return $this->hasMany(ShopVideoDescription::class, 'post_id', 'id');
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
        return ShopVideoDescription::create($dataInsert);
    }

    public function getListAdmin(array $dataSearch)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $category_id      = $dataSearch['category_id'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $tableDescription = (new ShopVideoDescription)->getTable();
        $tableProduct     = (new ShopVideo)->getTable();
        //Select field
        $dataSelect = $tableProduct.'.*, '.$tableDescription.'.name, '.$tableDescription.'.description, '.$tableDescription.'.content';

        $productList = (new ShopVideo)
            ->selectRaw($dataSelect)
            ->leftJoin($tableDescription, $tableDescription . '.post_id', $tableProduct . '.id');

        $productList = $productList
            ->where($tableDescription . '.lang', app()->getLocale());

        if(!empty($dataSearch['product_id']))
        {
            $productList = $productList->where($tableProduct .'.product_id', $dataSearch['product_id']);
        }
        if(isset($dataSearch['parent']) && $dataSearch['parent'] === 0)
        {
            $productList = $productList->where($tableProduct .'.parent_id', 0);
        }
        elseif(!empty($dataSearch['parent']))
        {
            $productList = $productList->where($tableProduct .'.parent_id', $dataSearch['parent']);
        }

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

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($product) {
                $product->description()->delete();
                $product->categories()->detach();
            }
        );
    }
}
