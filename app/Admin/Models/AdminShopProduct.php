<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LocalizeController;

use App\Models\ShopCategory;
use App\Models\ShopProduct;
use App\Models\ShopProductDescription;
use App\Models\ShopEmailTemplate;

class AdminShopProduct extends ShopProduct
{
    /**
     * Get product detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getProductAdmin($id, $storeId = null)
    {
        $tableDescription = (new ShopProductDescription)->getTable();
        $tableProduct = (new ShopProduct)->getTable();
        $data =  self::where('id', $id)
        ->leftJoin($tableDescription, $tableDescription . '.product_id', $tableProduct . '.id');

        if ($storeId) {
            $tableProductStore = (new ShopProductStore)->getTable();
            $data = $data->leftJoin($tableProductStore, $tableProductStore . '.product_id', $tableProduct . '.id');
            $data = $data->where($tableProductStore . '.store_id', $storeId);
        }

        $data = $data->first();
        return $data;
    }

    /**
     * Get list product in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public static function getListAdmin(array $dataSearch, $storeId = null)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $category_id      = $dataSearch['category_id'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $status          = $dataSearch['status'] ?? '';
        $tableDescription = (new ShopProductDescription)->getTable();
        $tablePTC         = (new ShopCategory)->getTable();
        $tableProduct     = (new ShopProduct)->getTable();
        //Select field
        $dataSelect = $tableProduct.'.*, '.$tableDescription.'.name, '.$tableDescription.'.seo_title,'.$tableDescription.'.seo_keyword,'.$tableDescription.'.seo_description, '.$tableDescription.'.description';

        $productList = (new ShopProduct)
            ->selectRaw($dataSelect)
            ->leftJoin($tableDescription, $tableDescription . '.post_id', $tableProduct . '.id');

        if ($category_id) {
            $productList = $productList
                ->join($tablePTC, $tablePTC . '.product_id', $tableProduct . '.id')
                ->where($tablePTC . '.category_id', $category_id);
        }
        
        $productList = $productList
            ->where($tableDescription . '.lang', sc_get_locale());

        if ($storeId) {
            // Only get products of store if store <> root or store is specified
            $productList = $productList->where($tableProductStore . '.store_id', $storeId);
        }

        if ($keyword) {
            $productList = $productList->where(function ($sql) use ($tableDescription, $tableProduct, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%')
                    ->orWhere($tableDescription . '.description', 'like', '%' . $keyword . '%')
                    ->orWhere($tableProduct . '.sku', 'like', '%' . $keyword . '%');
            });
        }
        $productList->groupBy($tableProduct.'.id');

        if($status == 'active')
        {
            $productList = $productList->where($tableProduct.'.status', 1);
        }
        if($status == 'not-active')
        {
            $productList = $productList->where($tableProduct.'.status', '<>', 1);
        }

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
     * Get list product select in admin
     *
     * @param   array  $dataFilter  [$dataFilter description]
     *
     * @return  []                  [return description]
     */
    public function getProductSelectAdmin(array $dataFilter = [], $storeId = null)
    {
        $keyword          = $dataFilter['keyword'] ?? '';
        $limit            = $dataFilter['limit'] ?? '';
        $kind             = $dataFilter['kind'] ?? [];
        $tableDescription = (new ShopProductDescription)->getTable();
        $tableProduct     = $this->getTable();
        $tableProductStore = (new ShopProductStore)->getTable();
        $colSelect = [
            'id',
            'sku',
             $tableDescription . '.name'
        ];
        $productList = (new ShopProduct)->select($colSelect)
            ->leftJoin($tableDescription, $tableDescription . '.product_id', $tableProduct . '.id')
            ->leftJoin($tableProductStore, $tableProductStore . '.product_id', $tableProduct . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        if ($storeId) {
            // Only get products of store if store <> root or store is specified
            $productList = $productList->where($tableProductStore . '.store_id', $storeId);
        }

        if (is_array($kind) && $kind) {
            $productList = $productList->whereIn('kind', $kind);
        }
        if ($keyword) {
            $productList = $productList->where(function ($sql) use ($tableDescription, $tableProduct, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%')
                    ->orWhere($tableProduct . '.sku', 'like', '%' . $keyword . '%');
            });
        }

        if ($limit) {
            $productList = $productList->limit($limit);
        }
        $productList->groupBy($tableProduct.'.id');
        $dataTmp = $productList->get()->keyBy('id');
        $data = [];
        foreach ($dataTmp as $key => $row) {
            $data[$key] = [
                'id' => $row['id'],
                'sku' => $row['sku'],
                'name' => addslashes($row['name']),
            ];
        }
        return $data;
    }


    /**
     * Create a new product
     *
     * @param   array  $dataInsert  [$dataInsert description]
     *
     * @return  [type]              [return description]
     */
    public static function createProductAdmin(array $dataInsert)
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
        return ShopProductDescription::create($dataInsert);
    }

    /**
     * Validate product
     *
     * @param   [type]$type     [$type description]
     * @param   null  $fieldValue    [$field description]
     * @param   null  $pId      [$pId description]
     * @param   null  $storeId  [$storeId description]
     * @param   null            [ description]
     *
     * @return  [type]          [return description]
     */
    public function checkProductValidationAdmin($type = null, $fieldValue = null, $pId = null, $storeId = null)
    {
        $tableProductStore = (new ShopProductStore)->getTable();
        $storeId = $storeId ? sc_clean($storeId) : session('adminStoreId');
        $type = $type ? sc_clean($type) : 'sku';
        $fieldValue = sc_clean($fieldValue);
        $pId = sc_clean($pId);
        $check =  $this
        ->leftJoin($tableProductStore, $tableProductStore . '.product_id', $this->getTable() . '.id')
        ->where($type, $fieldValue);
        $check = $check->where($tableProductStore . '.store_id', $storeId);
        if ($pId) {
            $check = $check->where($this->getTable().'.id', '<>', $pId);
        }
        $check = $check->first();

        if ($check) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get total product of system
     *
     * @return  [type]  [return description]
     */
    public static function getTotalProduct()
    {
        return self::count();
    }
    

    /**
     * Render html option price in admin
     *
     * @param   [type]$currency  [$currency description]
     * @param   nul   $rate      [$rate description]
     * @param   null             [ description]
     *
     * @return  [type]           [return description]
     */
    public function renderAttributeDetailsAdmin($currency = null, $rate = null)
    {
        $html = '';
        $details = $this->attributes()->get()->groupBy('attribute_group_id');
        $groups = ShopAttributeGroup::getListAll();
        foreach ($details as $groupId => $detailsGroup) {
            $html .= '<br><b><label>' . $groups[$groupId] . '</label></b>: ';
            foreach ($detailsGroup as $k => $detail) {
                $valueOption = $detail->name.'__'.$detail->add_price;
                $html .= '<label class="radio-inline"><input ' . (($k == 0) ? "checked" : "") . ' type="radio" name="add_att[' . $this->id . '][' . $groupId . ']" value="' . $valueOption . '">' . sc_render_option_price($valueOption, $currency, $rate) . '</label> ';
            }
        }
        return $html;
    }

    /**
     * Get list category id from product id
     *
     * @param [array] $arrProductId
     * @return collection
     */
    public function getListCategoryIdFromProductId($arrProductId)
    {
        return (new ShopProductCategory)->whereIn('product_id', $arrProductId)->get()->groupBy('product_id');
    }

    public function getProductComment()
    {
        return $this->hasMany(AdminShopProductComment::class, 'product_id', 'id')->orderByDesc('id');
    }

    public function rejectSendEmail($note='')
    {

        $checkContent = (new ShopEmailTemplate)->where('group', 'post_reject')->where('status', 1)->first();

        if ($checkContent) 
        {
            $content = $checkContent->text;
            $postEditURL = route('dangtin.edit', $this->id);
            $dataFind = [
                '/\{\{\$website\}\}/',
                '/\{\{\$dataContent\}\}/',
                '/\{\{\$postEditURL\}\}/',
            ];
            $dataReplace = [
                url('/'),
                $note,
                $postEditURL,
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);
            $dataView = [
                'content' => htmlspecialchars_decode($content)
            ];

            $config = [
                'to' => $this->getAuth->email??setting_option('email_admin'),
                'subject' => $checkContent->subject,
            ];

            sc_send_mail('email.customer_verify', $dataView, $config, $dataAtt = []);
            return true;
        }
    }
}
