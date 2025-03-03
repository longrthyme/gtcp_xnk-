<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Location\Facades\Location;

class ShopPaymentMethodItem extends Model
{
    public $timestamps = true;
    protected $guarded =[];
    protected static $listActiveAll = null;
    protected $location = null;

    public function setLocation($ip='')
    {
        $position = Location::get($ip);
        return $position;
    }

    public static function getAllActive()
    {
        if (!self::$listActiveAll) {
            self::$listActiveAll = self::where('status', 1)->get();
        }
        return self::$listActiveAll;
    }

    public function getList($dataSearch = [])
    {
        // $position = $this->setLocation("171.252.225.15");

        $method = $dataSearch['method']??'';

        $list = new ShopPaymentMethodItem;

        if($method != '')
        {
            $list = $list->where('method_id', $method);
        }
        /*if($position)
        {
            $list = $list->where('country_code', $position->countryCode);
        }*/

        $list = $list->where('status', 1)->get();

        return $list;
    }

    public function getListPosition($dataSearch = [])
    {
        $position = $this->setLocation(getIp());
        $currency = session()->get('currency')??setting_option('currency');

        $method = $dataSearch['method']??'';

        $list = new ShopPaymentMethodItem;

        if($method != '')
        {
            $list = $list->where('method_id', $method);
        }
        if($position)
        {
            // dd($this->getIp());
            $list = $list->where(function($query) use($position) {
                return $query->where('country_code', '')->orwhereJsonContains('country_code', $position->countryCode);
            });
        }
        $list = $list->where(function($query) use($currency) {
            return $query->where('invoice_currency', '')->orwhereJsonContains('invoice_currency', $currency);
        });

        $list = $list->orderByDesc('created_at');
        $list = $list->where('status', 1)->get();

        return $list;
    }

    public function getParentMethod()
    {
        return $this->hasOne(ShopPaymentMethod::class, 'id', 'method_id');
    }

    public function getPaymentCard()
    {
        $card = $this->code;
        $card = explode($card, "__");
        return $card[1]??'';
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }

    
}
