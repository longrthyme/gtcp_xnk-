<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RootAdminController;

use App\Libraries\Helpers;
use Illuminate\Support\Str;
use Auth, DB, File, Image, Config;

use App\Models\ShopLanguage;
use App\Admin\Models\AdminShopProduct;
use App\Admin\Models\AdminShopProductComment;
use App\Admin\Models\AdminShopCategory;

class AdminProductController extends RootAdminController
{
    public $view = 'admin.product';
    public $title_head;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
        $this->languages       = ShopLanguage::getListActive();
        $this->title_head = __('Sản phẩm');
        \App::setLocale($this->languages->where('set_default', 1)->first()->code);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index($status = 'active'){
        /*$countries = [
           2 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-vietnam.png", 'title' =>"Vietnam"],
           1 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-usa.png", 'title' =>"United States"],
           3 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-aghanistan.png", 'title' =>"Afghanistan"],
           4 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-albania.png", 'title' =>"Albania"],
           5 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-algeria.png", 'title' =>"Algeria"],
           6 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-andorra.png", 'title' =>"Andorra"],
           7 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-angola.png", 'title' =>"Angola"],
           8 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-antigua.png", 'title' =>"Antigua and Barbuda"],
           198 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Anguilla.png", 'title' =>"Anguilla"],
           9 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-argentina.png", 'title' =>"Argentina"],
           10 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-armenia.png", 'title' =>"Armenia"],
           11 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-australia.png", 'title' =>"Australia"],
           12 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-austria.png", 'title' =>"Austria"],
           13 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-azerbaijan.png", 'title' =>"Azerbaijan"],
           14 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-bahamas.png", 'title' =>"Bahamas"],
           15 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-bahrain.png", 'title' =>"Bahrain"],
           16 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-bangladesh.png", 'title' =>"Bangladesh"],
           17 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-barbados.png", 'title' =>"Barbados"],
           18 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-belarus.png", 'title' =>"Belarus"],
           19 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-belgium.png", 'title' =>"Belgium"],
           20 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-belize.png", 'title' =>"Belize"],
           21 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-benin.png", 'title' =>"Benin"],
           22 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-bhutan.png", 'title' =>"Bhutan"],
           23 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-bolivia.png", 'title' =>"Bolivia"],
           24 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-bosnia-hercegovina.png", 'title' =>"Bosnia and Hercegovina"],
           25 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-botswana.png", 'title' =>"Botswana"],
           26 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-brazil.png", 'title' =>"Brazil"],
           27 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-brunei.png", 'title' =>"Brunei"],
           28 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-bulgaria.png", 'title' =>"Bulgaria"],
           29 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-burkina-faso.png", 'title' =>"Burkina Faso"],
           30 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-burundi.png", 'title' =>"Burundi"],
           31 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Cabo-Verde.png", 'title' =>"Cape Verde"],
           32 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Cambodia.png", 'title' =>"Cambodia"],
           33 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Cameroon.png", 'title' =>"Cameroon"],
           34 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Canada.png", 'title' =>"Canada"],
           35 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Central-African-Republic.png", 'title' =>"Central African Republic"],
           36 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Chad.png", 'title' =>"Chad"],
           37 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Chile.png", 'title' =>"Chile"],
           38 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-China.png", 'title' =>"China"],
           39 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Colombia.png", 'title' =>"Colombia"],
           40 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Comoros.png", 'title' =>"Comoros"],
           41 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Congo.png", 'title' =>"Congo, Republic of the"],
           42 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Congo-Democratic-Republic.png", 'title' =>"Congo, Democratic Republic of the"],
           43 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Costa-Rica.png", 'title' =>"Costa Rica"],
           44 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Cote-d-Ivoire.png", 'title' =>"Cote d'Ivoire"],
           45 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Croatia.png", 'title' =>"Croatia"],
           46 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Cuba.png", 'title' =>"Cuba"],
           47 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Cyprus.png", 'title' =>"Cyprus"],
           48 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Czech-Republic.png", 'title' =>"Czech Republic"],
           49 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Denmark.png", 'title' =>"Denmark"],
           50 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Djibouti.png", 'title' =>"Djibouti"],
           51 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Dominca.png", 'title' =>"Dominca"],
           52 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Dominican-Republic.png", 'title' =>"Dominican Republic"],
           53 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Ecuador.png", 'title' =>"Ecuador"],
           54 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Egypt.png", 'title' =>"Egypt"],
           55 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-El-Salvador.png", 'title' =>"El Salvador"],
           56 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Equatorial-Guinea.png", 'title' =>"Equatorial Guinea"],
           57 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Eritrea.png", 'title' =>"Eritrea"],
           58 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Estonia.png", 'title' =>"Estonia"],
           59 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Ethiopia.png", 'title' =>"Ethiopia"],
           60 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Fiji.png", 'title' =>"Fiji"],
           61 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Finland.png", 'title' =>"Finland"],
           62 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-France.png", 'title' =>"France"],
           63 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Gabon.png", 'title' =>"Gabon"],
           64 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Gambia.png", 'title' =>"Gambia"],
           65 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Georgia.png", 'title' =>"Georgia"],
           66 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Germany.png", 'title' =>"Germany"],
           67 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Ghana.png", 'title' =>"Ghana"],
           68 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Greece.png", 'title' =>"Greece"],
           69 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Grenada.png", 'title' =>"Grenada"],
           70 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Guatemala.png", 'title' =>"Guatemala"],
           71 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Guinea.png", 'title' =>"Guinea"],
           72 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Guinea-Bissau.png", 'title' =>"Guinea-Bissau"],
           73 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Guyana.png", 'title' =>"Guyana"],
           74 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Haiti.png", 'title' =>"Haiti"],
           75 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Honduras.png", 'title' =>"Honduras"],
           76 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Hungary.png", 'title' =>"Hungary"],
           77 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Iceland.png", 'title' =>"Iceland"],
           78 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-India.png", 'title' =>"India"],
           79 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Indonesia.png", 'title' =>"Indonesia"],
           80 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Iran.png", 'title' =>"Iran"],
           81 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Iraq.png", 'title' =>"Iraq"],
           82 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Ireland.png", 'title' =>"Ireland"],
           83 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Israel.png", 'title' =>"Israel"],
           84 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Italy.png", 'title' =>"Italy"],
           85 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Jamaica.png", 'title' =>"Jamaica"],
           86 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Japan.png", 'title' =>"Japan"],
           87 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Jordan.png", 'title' =>"Jordan"],
           88 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Kazakhstan.png", 'title' =>"Kazakhstan"],
           89 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Kenya.png", 'title' =>"Kenya"],
           90 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Kiribati.png", 'title' =>"Kiribati"],
           91 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Kosovo.png", 'title' =>"Kosovo"],
           92 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Kuwait.png", 'title' =>"Kuwait"],
           93 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Kyrgyzstan.png", 'title' =>"Kyrgyzstan"],
           94 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Laos.png", 'title' =>"Laos"],
           95 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Latvia.png", 'title' =>"Latvia"],
           96 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Lebanon.png", 'title' =>"Lebanon"],
           97 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Lesotho.png", 'title' =>"Lesotho"],
           98 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Liberia.png", 'title' =>"Liberia"],
           99 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Libya.png", 'title' =>"Libya"],
           100 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Liechtenstein.png", 'title' =>"Liechtenstein"],
           101 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Lithuania.png", 'title' =>"Lithuania"],
           102 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Luxembourg.png", 'title' =>"Luxembourg"],
           103 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Macedonia.png", 'title' =>"Macedonia"],
           104 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Madagascar.png", 'title' =>"Madagascar"],
           105 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Malawi.png", 'title' =>"Malawi"],
           106 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Malaysia.png", 'title' =>"Malaysia"],
           107 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Maldives.png", 'title' =>"Maldives"],
           108 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Mali.png", 'title' =>"Mali"],
           109 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Malta.png", 'title' =>"Malta"],
           110 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Marshall-Islands.png", 'title' =>"Marshall Islands"],
           111 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Mauritania.png", 'title' =>"Mauritania"],
           112 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Mauritius.png", 'title' =>"Mauritius"],
           113 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Mexico.png", 'title' =>"Mexico"],
           114 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Micronesia.png", 'title' =>"Micronesia"],
           115 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Moldova.png", 'title' =>"Moldova"],
           116 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Monaco.png", 'title' =>"Monaco"],
           117 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Mongolia.png", 'title' =>"Mongolia"],
           118 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Montenegro.png", 'title' =>"Montenegro"],
           119 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Morocco.png", 'title' =>"Morocco"],
           120 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Mozambique.png", 'title' =>"Mozambique"],
           121 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Myanmar.png", 'title' =>"Myanmar"],
           122 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Namibia.png", 'title' =>"Namibia"],
           123 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Nauru.png", 'title' =>"Nauru"],
           124 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Nepal.png", 'title' =>"Nepal"],
           125 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Netherlands.png", 'title' =>"Netherlands"],
           126 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-New-Zealand.png", 'title' =>"New Zealand"],
           127 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Nicaragua.png", 'title' =>"Nicaragua"],
           128 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Niger.png", 'title' =>"Niger"],
           129 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Nigeria.png", 'title' =>"Nigeria"],
           130 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-North-Korea.png", 'title' =>"North Korea"],
           131 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Norway.png", 'title' =>"Norway"],
           132 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Oman.png", 'title' =>"Oman"],
           133 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Pakistan.png", 'title' =>"Pakistan"],
           134 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Palau.png", 'title' =>"Palau"],
           135 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Palestine.png", 'title' =>"Palestine"],
           136 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Panama.png", 'title' =>"Panama"],
           137 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Papua-New-Guinea.png", 'title' =>"Papua New Guinea"],
           138 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Paraguay.png", 'title' =>"Paraguay"],
           139 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Peru.png", 'title' =>"Peru"],
           140 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Philippines.png", 'title' =>"Philippines"],
           141 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Poland.png", 'title' =>"Poland"],
           142 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Portugal.png", 'title' =>"Portugal"],
           143 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Qatar.png", 'title' =>"Qatar"],
           144 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Romania.png", 'title' =>"Romania"],
           145 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Russia.png", 'title' =>"Russia"],
           146 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Rwanda.png", 'title' =>"Rwanda"],
           147 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-St-Kitts-Nevis.png", 'title' =>"St. Kitts and Nevis"],
           148 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-St-Lucia.png", 'title' =>"St. Lucia"],
           149 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-St-Vincent-the-Grenadines.png", 'title' =>"St. Vincent and The Grenadines"],
           150 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Samoa.png", 'title' =>"Samoa"],
           151 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-San-Marino.png", 'title' =>"San Marino"],
           152 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Sao-Tome-and-Principe.png", 'title' =>"Sao Tome and Principe"],
           153 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Saudi-Arabia.png", 'title' =>"Saudi Arabia"],
           154 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Senegal.png", 'title' =>"Senegal"],
           155 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Serbia.png", 'title' =>"Serbia"],
           156 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Seychelles.png", 'title' =>"Seychelles"],
           157 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Sierra-Leone.png", 'title' =>"Sierra Leone"],
           158 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Singapore.png", 'title' =>"Singapore"],
           159 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Slovakia.png", 'title' =>"Slovakia"],
           160 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Slovenia.png", 'title' =>"Slovenia"],
           161 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Solomon-Islands.png", 'title' =>"Solomon Islands"],
           162 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Somalia.png", 'title' =>"Somalia"],
           163 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-South-Africa.png", 'title' =>"South Africa"],
           164 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-South-Korea.png", 'title' =>"South Korea"],
           165 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-South-Sudan.png", 'title' =>"South Sudan"],
           166 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Spain.png", 'title' =>"Spain"],
           167 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Sri-Lanka.png", 'title' =>"Sri Lanka"],
           168 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Sudan.png", 'title' =>"Sudan"],
           169 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Suriname.png", 'title' =>"Suriname"],
           170 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Swaziland.png", 'title' =>"Swaziland"],
           171 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Sweden.png", 'title' =>"Sweden"],
           172 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Switzerland.png", 'title' =>"Switzerland"],
           173 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Syria.png", 'title' =>"Syria"],
           174 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Taiwan.png", 'title' =>"Taiwan"],
           175 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Tajikistan.png", 'title' =>"Tajikistan"],
           176 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Tanzania.png", 'title' =>"Tanzania"],
           177 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Thailand.png", 'title' =>"Thailand"],
           178 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Timor-Leste.png", 'title' =>"Timor-Leste"],
           179 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Togo.png", 'title' =>"Togo"],
           180 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Tonga.png", 'title' =>"Tonga"],
           181 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Trinidad-and-Tobago.png", 'title' =>"Trinidad and Tobago"],
           182 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Tunisia.png", 'title' =>"Tunisia"],
           183 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Turkey.png", 'title' =>"Turkey"],
           184 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Turkmenistan.png", 'title' =>"Turkmenistan"],
           185 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Tuvalu.png", 'title' =>"Tuvalu"],
           186 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Uganda.png", 'title' =>"Uganda"],
           187 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Ukraine.png", 'title' =>"Ukraine"],
           188 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-United-Arab-Emirates.png", 'title' =>"United Arab Emirates"],
           189 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-United-Kingdom.png", 'title' =>"United Kingdom"],
           190 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Uruguay.png", 'title' =>"Uruguay"],
           191 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Uzbekistan.png", 'title' =>"Uzbekistan"],
           192 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Vanuatu.png", 'title' =>"Vanuatu"],
           193 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Vatican-City.png", 'title' =>"Vatican City"],
           194 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Venezuela.png", 'title' =>"Venezuela"],
           195 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Yemen.png", 'title' =>"Yemen"],
           196 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Zambia.png", 'title' =>"Zambia"],
           197 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Zimbabwe.png", 'title' =>"Zimbabwe"],
           199 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Aruba.png", 'title' =>"Aruba"],
           200 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Bonaire.png", 'title' =>"Bonaire, Sint Eustatius and Saba"],
           201 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Bouvet_Island.png", 'title' =>"Bouvet Island"],
           202 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-British_Indian_Ocean_Territory.png", 'title' =>"British Indian Ocean Territory"],
           203 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Cayman_Islands.png", 'title' =>"Cayman Islands"],
           204 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Curacao.png", 'title' =>"CuraÃ§ao"],
           205 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Falkland_Islands_Malvinas.png", 'title' =>"Falkland Islands (Malvinas)"],
           206 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-French_Guiana.png", 'title' =>"French Guiana"],
           207 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-French_Southern_Territories.png", 'title' =>"French Southern Territories"],
           208 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Guadeloupe.png", 'title' =>"Guadeloupe"],
           209 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Guernsey.png", 'title' =>"Guernsey"],
           210 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Jersey.png", 'title' =>"Jersey"],
           211 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Martinique.png", 'title' =>"Martinique"],
           212 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Mayotte.png", 'title' =>"Mayotte"],
           213 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Montserrat.png", 'title' =>"Montserrat"],
           214 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Puerto_Rico.png", 'title' =>"Puerto Rico"],
           215 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Reunion.png", 'title' =>"RÃ©union"],
           216 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Saint_Barthelemy.png", 'title' =>"Saint BarthÃ©lemy"],
           217 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Saint_Helena.png", 'title' =>"Saint Helena, Ascension and Tristan da Cunha"],
           218 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Sint_Maarten_Dutch.png", 'title' =>"Saint Martin (French part)"],
           219 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Sint_Maarten_Dutch.png", 'title' =>"Sint Maarten (Dutch part)"],
           220 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-South_Georgia_South_Sandwich_Islands.png", 'title' =>"South Georgia and the South Sandwich Islands"],
           221 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Turks_Caicos_Islands.png", 'title' =>"Turks and Caicos Islands"],
           222 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Virgin_Islands_British.png", 'title' =>"Virgin Islands (British)"],
           223 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Virgin_Islands_US.png", 'title' =>"Virgin Islands (U.S.)"],
           224 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Aland_Islands.png", 'title' =>"Aland Islands"],
           225 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-American_Samoa.png", 'title' =>"American Samoa"],
           226 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Antarctica.png", 'title' =>"Antarctica"],
           227 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Bermuda.png", 'title' =>"Bermuda"],
           228 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Christmas_Island.png", 'title' =>"Christmas Island"],
           229 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Cocos_Keeling_Islands.png", 'title' =>"Cocos (Keeling) Islands"],
           230 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Cook_Islands.png", 'title' =>"Cook Islands"],
           231 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Faroe_Islands.png", 'title' =>"Faroe Islands"],
           232 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-French_Polynesia.png", 'title' =>"French Polynesia"],
           233 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Gibraltar.png", 'title' =>"Gibraltar"],
           234 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Greenland.png", 'title' =>"Greenland"],
           235 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Guam.png", 'title' =>"Guam"],
           236 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Heard_Island_McDonald_Islands.png", 'title' =>"Heard Island and McDonald Islands"],
           237 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Hong_Kong.png", 'title' =>"Hong Kong"],
           238 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Isle_Man.png", 'title' =>"Isle of Man"],
           239 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Macao.png", 'title' =>"Macao"],
           240 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-New_Caledonia.png", 'title' =>"New Caledonia"],
           241 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Niue.png", 'title' =>"Niue"],
           242 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Norfolk_Island.png", 'title' =>"Norfolk Island"],
           243 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Northern_Mariana_Islands.png", 'title' =>"Northern Mariana Islands"],
           244 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Pitcairn.png", 'title' =>"Pitcairn"],
           245 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Saint_Pierre_Miquelon.png", 'title' =>"Saint Pierre and Miquelon"],
           246 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Svalbard_Jan_Mayen.png", 'title' =>"Svalbard and Jan Mayen"],
           247 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Tokelau.png", 'title' =>"Tokelau"],
           248 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-United_States_Minor_Outlying_Islands.png", 'title' =>"United States Minor Outlying Islands"],
           249 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Wallis_Futuna.png", 'title' =>"Wallis and Futuna"],
           250 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-Western_Sahara.png", 'title' =>"Western Sahara"],
           251 => ['img' =>"https://cdn.phaata.com/assets/countries/flag-netherlands-antilles.png", 'title' =>"Netherlands Antilles"]
        ];
        foreach($countries as $index => $item)
        {
            \App\Models\LocationCountry::updateOrCreate(
                [
                    'name'    => $item['title']
                ],
                [
                    'id_new'    => $index
                ]
            );
        }
        dd($countries);*/

        // dd($status);

        $categoriesTitle = AdminShopCategory::getListTitleAdmin();
        
        $keyword     = request('keyword') ?? '';
        $category_id = request('category_id') ?? '';
        $sort_order  = request('sort_order') ?? 'id_desc';

        $arrSort = [
            'id__desc'   => __('ID giảm dần'),
            'id__asc'    => __('ID tăng dần'),
            'name__desc' => __('Theo thứ tự z-a'),
            'name__asc'  => __('Theo thứ tự a-z'),
        ];
        $dataSearch = [
            'keyword'     => $keyword,
            'category_id' => $category_id,
            'sort_order'  => $sort_order,
            'arrSort'     => $arrSort,
            'status'     => $status,
        ];
        $posts = (new AdminShopProduct)->getListAdmin($dataSearch);

        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'posts'            => $posts,
            'categoriesTitle'            => $categoriesTitle,
            'url_create'            => route('admin_product.create'),
            'total_item'            => $posts->count(),
            'urlDeleteItem'            => route('admin_product.delete'),
        ];
        
        return view($this->view .'.index', $data);
    }

    public function create(){
        $categories = (new AdminShopCategory)->getTreeCategoriesAdmin();
        // dd($categories);

        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'categories'            => $categories,
            'variables_selected'            => [],
            'url_post'            => route('admin_product.post'),
        ];

        $variables_selected = [];
        return view($this->view .'.single', $data);
    }

    public function edit($id){
        $langFirst = array_key_first($this->languages->toArray());

        $categories = (new AdminShopCategory)->getTreeCategoriesAdmin();
        $product = (new AdminShopProduct)->getDetail($id, '', false);

        //===========================================
        $categories = $product->getCategories();
        if($categories)
        {
            $category_main = current($categories);
            $category_main = (new AdminShopCategory)->getDetail($category_main['id']);

            $category_end = end($categories);
            $category = (new AdminShopCategory)->getDetail($category_end['id']);
        }
        //===========================================

        $comments = $product->getProductComment;

        $data = [
            'title'            => $this->title_head,
            'customer'  => $product->getAuth,
            'categories'  => $categories??[],
            'category_main'  => $category_main??[],
            'category'  => $category??[],
            'product'  => $product,
            'comments'  => $comments,
            'user'  => $product->getAuth,
            'options'  => $product->getOptions(),
            'galleries'  => $product->getGallery(),

            'languages'            => $this->languages,
            'langFirst'            => $langFirst,
            'url_post'            => route('admin_product.post'),
            'post_url'            => route('product', $product->slug),
        ];

        return view($this->view .'.single', $data);

    }

    public function post(){
        $data = request()->all();
        $post_id = $data['id'];
        $save = $data['submit']??'';

        $data_db    = [
            'status' => $data['status'] ?? 0,
            'created_at' => $data['created_at']??date('Y-m-d H:i'),
        ];

        if($save == 'reject')
        {
            return $this->reject($data);
        }

        if($post_id )
        {

            $post = AdminShopProduct::find($post_id);
            $post->update($data_db);
            $post->descriptions()->delete();
        }

        //description
        $dataDes = [];
        foreach ($data['description'] as $code => $row) 
        {
            $dataDes = [
                'post_id' => (int)$post_id,
                'lang' => $code,
                'description' => htmlspecialchars($row['description']??''),
                'content' => htmlspecialchars($row['content'] ?? ''),
                'seo_title' => $row['seo_title'] ?? '',
                'seo_keyword' => $row['seo_keyword'] ?? '',
                'seo_description' => $row['seo_description'] ?? '',
            ];
            AdminShopProduct::insertDescriptionAdmin($dataDes);
        }
        //description


        if($save == 'apply'){
            $msg = "Product has been Updated";
            $url = route('admin_product.edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
            
        }
        elseif(!empty($data['url_back']))
            return redirect($data['url_back'])->with(['success' => 'Product has been Updated/Create']);
        return redirect(route('admin_product'));
    }

    public function reject($data)
    {
        if($data['id'] && $data['note'])
        {
            $note = $data['note']??'';
            AdminShopProductComment::create([
                'product_id'  => $data['id'],
                'admin_id'  => auth()->user()->id,
                'content'  => $note,
                'status'    => 1
            ]);

            $product = AdminShopProduct::find($data['id']);
            $product->status = $data['status']??3;
            $product->save();
            $product->rejectSendEmail($note);
            
            $url = route('admin_product.edit', array($data['id']));
            Helpers::msg_move_page('Gửi thông tin từ chối thành công', $url);
        }
    }

    public function deleteList()
    {
        if (!request()->ajax())
        {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.method_not_allow')]);
        }
        else
        {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            $arrDontPermission = [];
            foreach ($arrID as $key => $id) {
                if (!$this->checkPermisisonItem($id))
                {
                    $arrDontPermission[] = $id;
                }
            }
            if (count($arrDontPermission)) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.remove_dont_permisison') . ': ' . json_encode($arrDontPermission)]);
            }
            AdminShopProduct::destroy($arrID);
            
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }
    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return AdminShopProduct::find($id);
    }

    public function duyettin()
    {
        return $this->index('not-active');
    }
    public function postDuyettin()
    {
        $id = request('id')??0;
        $value = request('value')??0;
        $message =  $value == 1 ?'Duyệt tin thành công': 'Ẩn tin đăng thành công';
        if($id)
        {
            AdminShopProduct::find($id)->update([
                'status'    => $value,
            ]);
            
        }
        return response()->json([
            'error' => false,
            'message'   => $message
        ]);
    }
}
