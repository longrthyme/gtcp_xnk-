<?php 

use App\Models\ShopPaymentMethod;

if (!function_exists('sc_payment_setting') && !in_array('sc_payment_setting', config('sc_payment_setting', []))) {
    //Get all language
    function sc_payment_setting($code)
    {
        $setting = (new ShopPaymentMethod)->where('code', $code)->first();
        if($setting)
        	$setting = $setting->setting->pluck('value', 'key')->toArray();
        return $setting;
    }
}