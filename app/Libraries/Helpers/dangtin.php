<?php 


if (!function_exists('sc_location_convert')) {
    //Get all language
    function sc_location_convert($location)
    {
        	$location_origin = explode(',', $location);
         $location_origin = array_reverse($location_origin);
         $dataStore['address'] = trim($location_origin[4]??'');
         $dataStore['address3'] = trim($location_origin[3]??'');
         $dataStore['address2'] = trim($location_origin[2]??'');
         $dataStore['address1'] = trim($location_origin[1]??'');
         $dataStore['country'] = trim($location_origin[0]??'');
        return $dataStore;
    }
}