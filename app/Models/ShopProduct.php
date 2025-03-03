<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Models\ShopProductDescription;

class ShopProduct extends Model
{

    protected $table = 'shop_products';
    protected $primaryKey = 'id';
    protected  $guarded = [];
    protected  $sc_category = []; // array category id

    public function descriptions()
    {
        return $this->hasMany(ShopProductDescription::class, 'post_id', 'id');
    }

    public function getDateAvailable()
    {
        if($this->date_available)
            return date('d/m/Y', strtotime($this->date_available));
    }

    public function options()
    {
        return $this->hasMany(ShopProductOption::class, 'product_id', 'id');
    }

    //Function get text description
    public function getText()
    {
        return $this->descriptions()->where('lang', sc_get_locale())->first();
    }

    public function getInfoContact()
    {
        return $this->hasOne(ShopProductContact::class, 'product_id', 'id');
    }

    public function getSeo()
    {
        $options = $this->getOptions();
        // dd($options);
        $name = $this->name??'';

        if($name == '')
        {
            $name = array_filter([$this->getAuth->company,($options[104]??''), ($options[30]??''), ($options[202]??''), $this->sku]);
            if(count($name))
                $name = implode(' - ', $name);
        }

        return [
            'seo_title' => $this->seo_title !='' ? $this->seo_title : $name,
            'seo_image' => asset($this->image),
            'seo_description'   => $this->seo_description ?? ($name??''),
            'seo_keyword'   => $this->seo_keyword ?? '',
        ];

    }

    /**
     * Set array category 
     *
     * @param   [array|int]  $category 
     *
     */
    public function setCategory($category)
    {
        if (is_array($category))
        {
            $this->sc_category = $category;
        }
        else
        {
            $this->sc_category = array((int)$category);
        }
        return $this;
    }

    public function getSeoTitleAttribute($value)
    {
        if(empty($value) || $value === null)
        {
            return $this->name;
        }
        return $value;
    }

    public function getListData()
    {
        $tableDescription = (new ShopProductDescription)->getTable();
        $tablePTC         = (new ShopProductCategory)->getTable();
        $tableProduct     = (new ShopProduct)->getTable();
        $tableProductOption     = (new ShopProductOption)->getTable();
        
        //Select field
        $dataSelect = $tableProduct.'.*, '.$tableDescription.'.name, '.$tableDescription.'.description, '.$tableDescription.'.content, '.$tableDescription.'.duration';

        $productList = (new ShopProduct)
            ->selectRaw($dataSelect)
            ->leftJoin($tableDescription, $tableDescription . '.post_id', $tableProduct . '.id')
            ->where($tableDescription . '.lang', app()->getLocale());

        return $productList;
    }

    public function getList(array $dataSearch, $count = false)
    {
        $keyword          = $dataSearch['keyword'] ?? '';
        $sort_order       = $dataSearch['sort_order'] ?? '';
        $arrSort          = $dataSearch['arrSort'] ?? '';
        $price          = $dataSearch['price'] ?? '';
        $price_type          = $dataSearch['price_type'] ?? '';

        $province_slug          = $dataSearch['province'] ?? '';
        $district_slug          = $dataSearch['district'] ?? '';
        $hot          = $dataSearch['hot'] ?? 0;
        $user_id          = $dataSearch['user_id'] ?? 0;
        $limit          = $dataSearch['limit'] ?? 0;
        $post_type          = $dataSearch['post_type'] ?? '';
        $country          = $dataSearch['country'] ?? '';
        $location_origin          = $dataSearch['location_origin'] ?? '';
        $destination          = $dataSearch['destination'] ?? '';
        $option          = $dataSearch['option'] ?? '';
        $get_all          = $dataSearch['get_all'] ?? '';
        $getAllActive          = $dataSearch['getAllActive'] ?? 0; //get all active
        $acreage          = $dataSearch['acreage'] ?? '';
        $image          = $dataSearch['image'] ?? false;
        $product_home          = $dataSearch['product_home'] ?? false;

        $transportation          = $dataSearch['transportation'] ?? '';
        
        $tableDescription = (new ShopProductDescription)->getTable();
        $tablePTC         = (new ShopProductCategory)->getTable();
        $tableProduct     = (new ShopProduct)->getTable();
        $tableProductOption     = (new ShopProductOption)->getTable();

        $productList = $this->getListData();


        if (count($this->sc_category)) {
            $productList = $productList->leftJoin($tablePTC, $tablePTC . '.product_id', $this->getTable() . '.id');
            $productList = $productList->whereIn($tablePTC . '.category_id', $this->sc_category)->groupBy($tablePTC . '.product_id');
        }

        if ($option != '') {
            $productList = $productList->leftJoin($tableProductOption, $tableProductOption . '.product_id', $this->getTable() . '.id');
            $productList = $productList->where($tableProductOption . '.value', $option)->groupBy($tableProductOption . '.product_id');
        }

        if ($transportation != '') {
            $productList = $productList->leftJoin($tableProductOption, $tableProductOption . '.product_id', $this->getTable() . '.id');
            $productList = $productList->where($tableProductOption . '.value', $transportation)->groupBy($tableProductOption . '.product_id');
        }

        if ($keyword)
        {
            $productList = $productList->where(function ($sql) use ($tableDescription, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%');
            });
        }
        if ($acreage)
        {
            $acreage_letter = substr($acreage, 0, 1);
            if(in_array($acreage_letter, ['<','>']))
            {
                $price_ = explode($acreage_letter, $acreage);

                $productList = $productList->where('acreage', "$acreage_letter=", $price_[1]);
            }
            else
            {
                $price_ = explode('-',$acreage);

                if(!empty($price_[0]) && !empty($price_[1]))
                {
                    $productList = $productList->where('acreage','>', $price_[0]);
                    $productList = $productList->where('acreage','<', $price_[1]);
                }
                else
                    $productList = $productList->where('acreage', $acreage);
            }
        }

        if($image)
        {
            $productList = $productList->where('image', '<>', '');
        }
        if($country)
        {
            $productList = $productList->where('country', $country);
        }
        if($location_origin)
        {
            $location_arr = array_filter(sc_location_convert($location_origin));
            // dd($location_arr);
            $productList = $productList->where($location_arr);
        }
        if($destination)
        {
            $productList = $productList->where('address_end', 'like', "%$destination%");
        }

        if($price)
        {
            $price_letter = substr($price, 0, 1);
            if(in_array($price_letter, ['<','>']))
            {
                $price_ = explode($price_letter, $price);

                $productList = $productList->where('price', "$price_letter=", $price_[1]);
            }
            else
            {
                $price_ = explode('-',$price);

                if(!empty($price_[0]) && !empty($price_[1]))
                {
                    $productList = $productList->where('price','>=', $price_[0]);
                    $productList = $productList->where('price','<=', $price_[1]);
                }
                else
                    $productList = $productList->where('price', $price);
            }
        }

        if($province_slug != ''){
            $province = \App\Models\LocationProvince::where('slug', $province_slug)->first();

            if($province)
                $productList = $productList->whereHas('getInfo', function($query) use($province){
                    return $query->where('province_id', $province->id);
                });
        }
            
        if($district_slug != ''){
            $district = \App\Models\LocationDistrict::where('slug', $district_slug)->first();
            
            if($district)
            {
                $productList = $productList->whereHas('getInfo', function($query) use($district){
                    return $query->where('district_id', $district->id);
                });
            }
        }

        if($user_id)
        {
            $productList = $productList->where('user_id', $user_id);
        }
        if($hot)
        {
            $productList = $productList->where('hot', 1);
        }
        
        if(is_array($post_type))
            $productList = $productList->whereIn('post_type', $post_type);
        elseif($post_type != '')
            $productList = $productList->where('post_type', $post_type);

        $productList->groupBy($tableProduct.'.id');
        if($get_all == '')
        {
            $productList = $productList->where('status', 1);
        }

        if($product_home)
        {
            $productList = $productList->where('package_id', '>', 0);
        }

        if ($sort_order)
        {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $productList = $productList->orderBy($field, $sort_field);
        }
        else
        {
            $productList = $productList->orderBy($tableProduct.'.created_at', 'desc');
            if($product_home)
                $productList = $productList->orderBy($tableProduct.'.package_id', 'desc');
        }

        // $productList = $productList->where('date_available', '>=', date('Y-m-d'));

        if($limit)
            $productList = $productList->limit($limit)->get();
        elseif($getAllActive)
            $productList = $productList->get();
        else
            $productList = $productList->paginate(20);
        
        return $productList;
    }

    public function showPrice()
    {
        $priceFinal = $this->promotion ?? 0;
        $price = $this->price ?? 0;
        $variables_item = $this->getVariables->first();
        if($variables_item){
            $price = $variables_item->price;
            $priceFinal = $variables_item->promotion;
        }
        return view( env('APP_THEME', 'theme') .'.product.includes.showPrice',[
            'priceFinal' => $priceFinal,
            'price' => $price,
        ]);
    }
    public function showPriceDetail($options = null)
    {
        $priceFinal = $this->promotion ?? 0;
        $price = $this->price ?? 0;
        if($options != null)
        {
            $price = $options->price??0;
            $priceFinal = $options->promotion??0;
        }
        else
        {
            $variables_item = $this->getVariables->first();
            if($variables_item){
                $price = $variables_item->price;
                $priceFinal = $variables_item->promotion;
            }
        }

        return view( env('APP_THEME', 'theme') .'.product.includes.showPriceDetail',[
            'priceFinal' => $priceFinal,
            'price' => $price,
            'unit' => $this->unit,
        ]);
    }

    /*
    *Format price
    */
    public function getPrice()
    {
        $n = $this->price;
        $price_type = $this->price_type;
        $m = '';
        if($price_type==1)
            $m = '/m²';
        if($n > 0){
            $n = (0+str_replace(",","",$n));
           
            // is this a number?
            if(!is_numeric($n)) return false;
           
            // now filter it;
            if($n>1000000000000) return round(($n/1000000000000),1).' nghìn tỷ'.$m;
            else if($n>1000000000) return round(($n/1000000000),2).' tỷ'.$m;
            else if($n>1000000) return round(($n/1000000),1).' triệu'.$m;
            else if($n>1000) return round(($n/1000),1).' VNĐ'.$m;
            return $n.$m;
        }
        else
            return __('Thương lượng');
    }
    public function getPriceSub()
    {
        $n = $this->price;
        $price_type = $this->price_type;
        $m = '';
        if($price_type==1){
            $n = $n* $this->acreage;
        }
        else{
            $n = $n/$this->acreage;
            $m = '/m²';
        }

        if($n > 0 || $n != ''){
            $n = (0+str_replace(",","",$n));
           
            // is this a number?
            if(!is_numeric($n)) return false;
           
            // now filter it;
            if($n>1000000000000) return round(($n/1000000000000),1).' nghìn tỷ'.$m;
            else if($n>1000000000) return round(($n/1000000000),2).' tỷ'.$m;
            else if($n>1000000) return round(($n/1000000),1).' triệu'.$m;
            else if($n>1000) return round(($n/1000),1).' VNĐ'.$m;
            return $n.$m;
        }
        else
            return __('Giá thỏa thuận');
    }

    /*
    *gallery
    */
    public function getGallery(){
        if($this->gallery!='')
            return unserialize($this->gallery);
        return '';
    }
    public function countGallery(){
        if($this->gallery!='' || $this->gallery != null){
            return count(unserialize($this->gallery));
        }
        return 0;
    }

    /**
     * [getUrl description]
     * @return [type] [description]
     */
    public function getUrl($slug_parent = null)
    {
        if($this->slug != '')
            return sc_route('product', ['slug' => $this->slug]);
        else
            return sc_route('product', ['slug' => $this->sku]);
        return;
    }

    public function getUrlBaoGia()
    {
        return sc_route('product.baogia', ['id' => $this->id]);
    }

    public function wishlist()
    {
        if(auth()->check()){
            $db = \App\Models\Wishlist::where('product_id', $this->id)->where('user_id', auth()->user()->id)->first();
            if($db!='')
                return true;
        }
        else{
            $wishlist = json_decode(\Cookie::get('wishlist'));
            // dd($wishlist);
            $key = false;
            if($wishlist!='' && count($wishlist)>0)
                $key = array_search( $this->id, $wishlist);

            if($key !== false)
                return true;
        }
        return false;
    }

    public function getWishList()
    {
        return $this->hasMany('App\Models\Wishlist', 'product_id', 'id');
    }

    /*user detail*/
    public function getAuth()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getThongke()
    {
        return $this->hasOne('App\Models\Thongke', 'product_id', 'id');
    }

    public function getPackage()
    {
        return $this->hasOne('App\Models\Package', 'id', 'package_id');
    }

    public function categories(){
        return $this->belongsToMany(ShopCategory::class, 'shop_product_category', 'product_id', 'category_id');
    }

    public function getCategories()
    {
        $tableDescription = (new ShopCategoryDescription)->getTable();
        $tableCategory     = (new ShopCategory)->getTable();

        $categories = $this->categories();
        if($categories->count())
        {
            $dataSelect = $tableCategory.'.*, '.$tableDescription.'.name, '.$tableDescription.'.description, '.$tableDescription.'.content';
            $data = $categories->selectRaw($dataSelect)
                                ->leftJoin($tableDescription, $tableDescription . '.category_id', $tableCategory . '.id')
                                ->where($tableCategory .'.status', 1)
                                ->where($tableDescription . '.lang', sc_get_locale())
                                ->get();

            $data = $data->toArray();
            array_multisort(
                array_column($data, 'parent'),
                array_column($data, 'id'),
                $data
            );
            return $data;
        }
    }

    public function getCategoryMain()
    {
        $categories = $this->getCategories();
        // dd($categories);
        $category_main = current($categories);
        $category_main = (new ShopCategory)->getDetail($category_main['id']);
        return $category_main;
    }

    public function getDetail($key = null, $type = null, $checkActive = 1)
    {
        if (empty($key)) {
            return null;
        }
        
        $tableDescription = (new ShopProductDescription)->getTable();

        $dataSelect = $this->getTable().'.*, '.$tableDescription.'.*';

        $post = $this->leftJoin($tableDescription, $tableDescription . '.post_id', $this->getTable() . '.id');
        
        $post = $post->where($tableDescription . '.lang', sc_get_locale());

        if (empty($type)) {
            $post = $post->where($this->getTable().'.id', $key);
        } 
        elseif ($type == 'slug') {
            $post = $post->where($this->getTable().'.slug', $key)->orWhere($this->getTable().'.sku', $key);
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

    public function checkAccessSection()
    {
        if(auth()->check())
        {
            $payment = \App\Models\PaymentRequest::where('package_id', $this->id)->where('user_id', auth()->user()->id)->where('status', 1)->first();
            if($this->price == 0 || $payment)
                return true;
        }
        return false;
    }

    function createOption($data)
    {
        $this->options()->delete();
        $options = ShopOption::whereIn('id', array_keys($data))->get();
        
        foreach($options as $item)
        {
            $option_id = $data[$item->id]?$item->id:0;
            $option_value = $data[$option_id]??'';

            if($item->type_data == 'number')
                $option_value = str_replace(',', '',  $option_value);
            if(is_array($option_value))
                $option_value = json_encode($option_value);
            if($option_id)
            {
                ShopProductOption::create([
                    'product_id' => $this->id,
                    'option_id' => $option_id,
                    'value' => $option_value,
                ]);
            }
        }
    }

    function createCatalogue($data, $type = 'catelogue')
    {
        $this->getCatalogue()->where('type', $type)->delete();
        foreach($data as $item)
        {
            ShopProductFile::create([
                'product_id' => $this->id,
                'type' => $type,
                'value' => $item,
            ]);
        }
    }

    public function getCatalogue()
    {
        return $this->hasMany(ShopProductFile::class, 'product_id', 'id');
    }

    function getOptions($json_decode_text=true)
    {
        $options = $this->options()->pluck('value', 'option_id')->toArray();

        foreach($options as $key => $item)
        {
            $value = json_decode($item);
            if(is_array($value))
            {
                if($json_decode_text)
                    $value = implode(', ', $value);

                $options[$key] = $value;
            }

        }
        
        return $options;
    }
    public function getOption($option_id='')
    {
        $option = $this->getOptions->where('option_id',$option_id)->first();
        if($option)
        {
            $value = json_decode($option->value);
            if(is_array($value))
                return $value;
            else
                return $option->value;
        }
    }

    function getAddressFull()
    {
        $arr = array_filter([$this->address, $this->address3, $this->address2, $this->address1, $this->country]);
        return $arr;
    }
    public function getAddressFullRender()
    {
        $addressFull = $this->getAddressFull();
        if(count($addressFull))
        {
            return implode(', ', $addressFull);
        }
        return;
    }
    function getAddressEnd()
    {
        if($this->address_end != '')
        {
            $address_end = explode(',', $this->address_end);
            $arr = array_filter($address_end);
            return $arr;
        }
    }

    public function getLocation($data)
    {
        if(is_array($data))
        {
            $arr = [];
            foreach ($data as $item)
            {
                if(!empty($this->$item))
                    $arr[] = $this->$item;
            }
            if(count($arr))
            {
                return implode(', ', $arr);
            }
        }
    }
    public function getOrigin()
    {
        return $this->country;
    }
    public function getPlaceSale()
    {
        $address = $this->getAddressEnd();
        $arr = array_filter([$address[count($address)-2]??'', $address[count($address)-1]??'']);
        if(count($arr))
            return implode(', ', $arr);
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($product) {
                if($product->gallery != '')
                {
                    $galleries = unserialize($product->gallery);
                    foreach($galleries as $item)
                    {
                        if(\File::exists(public_path($item)))
                            unlink(public_path($item));
                    }
                }

                $product->descriptions()->delete();
                $product->categories()->detach();
                $product->getInfoContact()->delete();
                $product->options()->delete();
            }
        );
    }
}
