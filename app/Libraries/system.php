<?php
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\SettingWatermark;
use App\Models\ShopCurrency;
use App\Libraries\Helpers;
use App\Models\BlockContent;


//Product kind
define('SC_PRODUCT_SINGLE', 0);
define('SC_PRODUCT_BUILD', 1);
define('SC_PRODUCT_GROUP', 2);
//Product property
define('SC_PROPERTY_PHYSICAL', 'physical');
define('SC_PROPERTY_DOWNLOAD', 'download');
// list ID admin guard
define('SC_GUARD_ADMIN', ['1']); // admin
// list ID language guard
define('SC_GUARD_LANGUAGE', ['1', '2']); // vi, en
// list ID currency guard
define('SC_GUARD_CURRENCY', ['1', '2']); // vndong , usd
// list ID ROLES guard
define('SC_GUARD_ROLES', ['1', '2']); // admin, only view

define('SC_PRICE_FILTER', [1 => 'Từ 0 - 1.000.000 đ', 2=>'Từ 1.000.000 đ - 3.000.000 đ',3=>'Từ 3.000.000 đ - 5.000.000 đ', 4=>'Từ 5.000.000 đ - 10.000.000 đ',5=>'Từ 10.000.000 đ - Trở lên']); // price filter

/**
 * Admin define
 */
define('SC_ADMIN_MIDDLEWARE', ['web', 'admin']);
define('SC_FRONT_MIDDLEWARE', ['web']);
define('SC_API_MIDDLEWARE', ['api', 'api.extent']);
define('SC_CONNECTION', 'mysql');
define('SC_CONNECTION_LOG', 'mysql');
//Prefix url admin
define('SC_ADMIN_PREFIX', env('ADMIN_PREFIX', 'admin'));

// Root ID store
define('SC_ID_ROOT', 1);


if (!function_exists('convert_to_slug')) {
    function convert_to_slug($value)
    {
        return Str::slug($value);
    }
}

if (!function_exists('setting_option')) {
    function setting_option($variable = '')
    {
        if (Cache::has('theme_option')) {
            $data = Cache::get('theme_option');
        // dd($data);
        }
        else{
            $data = Setting::get();
            Cache::forever('theme_option', $data);
        }
        if($data){
            $option = $data->where('name', $variable)->first();
            // dd($option);
            if($option){
                $content = $option->content;
                if($option->type == 'editor' || $option->type == 'text')
                    $content = htmlspecialchars_decode(htmlspecialchars_decode($content));
                return $content;
            }
        }
    }
}
if (!function_exists('setting_watermark')) {
    function setting_watermark($variable = '')
    {
        $data = SettingWatermark::get();
    
        if($data){
            $option = $data->where('name', $variable)->first();
            // dd($option);
            if($option){
                $content = $option->content;
                if($option->type == 'editor' || $option->type == 'text')
                    $content = htmlspecialchars_decode(htmlspecialchars_decode($content));
                return $content;
            }
        }
    }
}

if (!function_exists('get_template')) {
    function get_template()
    {
        return Helpers::getTemplatePath();
    }
}

if (!function_exists('render_price')) {
    function render_price(float $money, $currency = null, $rate = null, $space_between_symbol = false, $useSymbol = true)
    {
        return ShopCurrency::render($money, $currency, $rate, $space_between_symbol, $useSymbol);
    }
}
if (!function_exists('render_option_name')) {
    function render_option_name($att)
    {
        if($att){
            $att_array = explode('__', $att);
            if(isset($att_array[0]))
                return $att_array[0];
        }
    }
}
if (!function_exists('render_option_price')) {
    function render_option_price($att)
    {
        if($att){
            $att_array = explode('__', $att);
            if(isset($att_array[2]))
                return render_price($att_array[2]);
            elseif(isset($att_array[1]))
                return render_price($att_array[1]);
        }
    }
}
if (!function_exists('auto_code')) {
    function auto_code($code = 'Order', $cart_id = 0){
        $number_start = 5000;
        // $strtime_conver=strtotime(date('d-m-Y H:i:s'));
        // $strtime=substr($strtime_conver,-4);
        // $rand=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $string_rand = $code . ($number_start + $cart_id);
        return $string_rand;
    }
}

/*
Get all layouts
 */
if (!function_exists('sc_store_block')) {
    function sc_store_block()
    {
        return BlockContent::getLayout();
    }
}

if(!function_exists('queryParam')) {
    function queryParam($routeName, $params=[]){
        if(count($params))
        {
            $params_ = [];
            foreach($params as $key => $item)
            {
                if($item != '')
                {
                    $params_[$key]  = $item;
                }
                
            }
            return route($routeName, $params_);
        }
    }
}


/**
 * Function render point data
 */
if (!function_exists('sc_product_get_rating')) {
    function sc_product_get_rating($pId = 0) {
        if (sc_config_global('ProductReview')) {
            $pointData = \App\Plugins\Cms\ProductReview\Models\PluginModel::getPointData($pId);
        } else {
            $pointData =  [];
        }
        return $pointData;
    }
}


if (!function_exists('sc_push_include_view')) {
    /**
     * Push view
     *
     * @param   [string]  $position
     * @param   [string]  $pathView
     *
     */
    function sc_push_include_view($position, $pathView)
    {
        $includePathView = config('sc_include_view.'.$position, []);
        $includePathView[] = $pathView;
        config(['sc_include_view.'.$position => $includePathView]);
    }
}


if (!function_exists('sc_push_include_script')) {
    /**
     * Push script
     *
     * @param   [string]  $position
     * @param   [string]  $pathScript
     *
     */
    function sc_push_include_script($position, $pathScript)
    {
        $includePathScript = config('sc_include_script.'.$position, []);
        $includePathScript[] = $pathScript;
        config(['sc_include_script.'.$position => $includePathScript]);
    }
}


if (!function_exists('sc_html_render')) {
    /*
    Html render
     */
    function sc_html_render($string)
    {
        $string = htmlspecialchars_decode($string);
        return $string;
    }
}

if (!function_exists('sc_convert_time')) {
    /*
    time: int
     */
    function sc_convert_time($time)
    {
        $count = strlen($time);
        if($count%2 != 0)
            $time = '0'.$time;

        $array = str_split($time, 2);

        return implode(':', $array);
    }
}
if (!function_exists('sc_convert_duration')) {
    /*
    time: int
     */
    function sc_convert_duration($time)
    {
        $count = strlen($time);

        $array = str_split($time, 2);
        $array_end = $array[3]??0;
        unset($array[3]);
        // dd($array);
        $array = implode(':', $array);
        if($array_end)
            $array = implode(',', [$array, $array_end]);

        return $array;
    }
}

function implodeAddress($address)
{
    if(is_array($address))
    {
        return implode(', ', $address);
    }
}