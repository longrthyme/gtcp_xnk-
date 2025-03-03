<?php 

use App\Models\ShopOption;

if (!function_exists('sc_option_unit')) {
    //Get all language
    function sc_option_unit($id)
    {
        $option = ShopOption::find($id);
        
        return $option->unit??'';
    }
}