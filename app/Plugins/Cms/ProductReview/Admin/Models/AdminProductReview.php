<?php

namespace App\Plugins\Cms\ProductReview\Admin\Models;

use App\Plugins\Cms\ProductReview\Models\PluginModel;

class AdminProductReview extends PluginModel
{
    protected static $getListTitleAdmin = null;
    protected static $getListCategoryGroupByParentAdmin = null;

    /**
     * Get list category in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public function getReviewListAdmin(array $dataSearch) {
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? [];
        $data = $this;

        $data = $data->where('parent', 0);
        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $data = $data->orderBy($field, $sort_field);
        } else {
            $data = $data->orderBy('id', 'desc');
        }
        $data = $data->paginate(20);

        return $data;
    }

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }

}
