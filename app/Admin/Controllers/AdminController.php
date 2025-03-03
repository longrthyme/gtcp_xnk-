<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting, App\Models\Admin, App\Models\Addtocard;
use App\Models\Theme, App\Models\Category_Theme, App\Models\Join_Category_Theme, App\Models\Rating_Product;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use App\User;
use Auth, DB, File, Image, Redirect, Cache;
use App\Exports\CustomerExport;
use App\Exports\OrderExport;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\WebService\WebService;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function error(){
        return view('errors.404');
    }
    
    public function getMenu(){
        /*$array = [
           [
            'link' => "vi|af",
            'code' => "af",
            'title' => "Afrikaans"
           ],
           [
            'link' => "vi|sq",
            'code' => "sq",
            'title' => "Albanian"
           ],
           [
            'link' => "vi|am",
            'code' => "am",
            'title' => "Amharic"
           ],
           [
            'link' => "vi|ar",
            'code' => "ar",
            'title' => "Arabic"
           ],
           [
            'link' => "vi|hy",
            'code' => "hy",
            'title' => "Armenian"
           ],
           [
            'link' => "vi|az",
            'code' => "az",
            'title' => "Azerbaijani"
           ],
           [
            'link' => "vi|eu",
            'code' => "eu",
            'title' => "Basque"
           ],
           [
            'link' => "vi|be",
            'code' => "be",
            'title' => "Belarusian"
           ],
           [
            'link' => "vi|bn",
            'code' => "bn",
            'title' => "Bengali"
           ],
           [
            'link' => "vi|bs",
            'code' => "bs",
            'title' => "Bosnian"
           ],
           [
            'link' => "vi|bs",
            'code' => "bs",
            'title' => "Bosnian"
           ],
           [
            'link' => "vi|bg",
            'code' => "bg",
            'title' => "Bulgarian"
           ],
           [
            'link' => "vi|ca",
            'code' => "ca",
            'title' => "Catalan"
           ],
           [
            'link' => "vi|ceb",
            'code' => "ceb",
            'title' => "Cebuano"
           ],
           [
            'link' => "vi|ny",
            'code' => "ny",
            'title' => "Chichewa"
           ],
           [
            'link' => "vi|zh-CN",
            'code' => "zh-CN",
            'title' => "Chinese (Simplified)"
           ],
           [
            'link' => "vi|zh-TW",
            'code' => "zh-TW",
            'title' => "Chinese (Traditional)"
           ],
           [
            'link' => "vi|co",
            'code' => "co",
            'title' => "Corsican"
           ],
           [
            'link' => "vi|hr",
            'code' => "hr",
            'title' => "Croatian"
           ],
           [
            'link' => "vi|cs",
            'code' => "cs",
            'title' => "Czech"
           ],
           [
            'link' => "vi|da",
            'code' => "da",
            'title' => "Danish"
           ],
           [
            'link' => "vi|nl",
            'code' => "nl",
            'title' => "Dutch"
           ],
           [
            'link' => "vi|en",
            'code' => "en",
            'title' => "English"
           ],
           [
            'link' => "vi|eo",
            'code' => "eo",
            'title' => "Esperanto"
           ],
           [
            'link' => "vi|et",
            'code' => "et",
            'title' => "Estonian"
           ],
           [
            'link' => "vi|tl",
            'code' => "tl",
            'title' => "Filipino"
           ],
           [
            'link' => "vi|fi",
            'code' => "fi",
            'title' => "Finnish"
           ],
           [
            'link' => "vi|fr",
            'code' => "fr",
            'title' => "French"
           ],
           [
            'link' => "vi|fy",
            'code' => "fy",
            'title' => "Frisian"
           ],
           [
            'link' => "vi|gl",
            'code' => "gl",
            'title' => "Galician"
           ],
           [
            'link' => "vi|ka",
            'code' => "ka",
            'title' => "Georgian"
           ],
           [
            'link' => "vi|de",
            'code' => "de",
            'title' => "German"
           ],
           [
            'link' => "vi|el",
            'code' => "el",
            'title' => "Greek"
           ],
           [
            'link' => "vi|gu",
            'code' => "gu",
            'title' => "Gujarati"
           ],
           [
            'link' => "vi|ht",
            'code' => "ht",
            'title' => "Haitian Creole"
           ],
           [
            'link' => "vi|ha",
            'code' => "ha",
            'title' => "Hausa"
           ],
           [
            'link' => "vi|haw",
            'code' => "haw",
            'title' => "Hawaiian"
           ],
           [
            'link' => "vi|iw",
            'code' => "iw",
            'title' => "Hebrew"
           ],
           [
            'link' => "vi|hi",
            'code' => "hi",
            'title' => "Hindi"
           ],
           [
            'link' => "vi|hmn",
            'code' => "hmn",
            'title' => "Hmong"
           ],
           [
            'link' => "vi|hu",
            'code' => "hu",
            'title' => "Hungarian"
           ],
           [
            'link' => "vi|is",
            'code' => "is",
            'title' => "Icelandic"
           ],
           [
            'link' => "vi|ig",
            'code' => "ig",
            'title' => "Igbo"
           ],
           [
            'link' => "vi|id",
            'code' => "id",
            'title' => "Indonesian"
           ],
           [
            'link' => "vi|ga",
            'code' => "ga",
            'title' => "Irish"
           ],
           [
            'link' => "vi|it",
            'code' => "it",
            'title' => "Italian"
           ],
           [
            'link' => "vi|ja",
            'code' => "ja",
            'title' => "Japanese"
           ],
           [
            'link' => "vi|jw",
            'code' => "jw",
            'title' => "Javanese"
           ],
           [
            'link' => "vi|kn",
            'code' => "kn",
            'title' => "Kannada"
           ],
           [
            'link' => "vi|kk",
            'code' => "kk",
            'title' => "Kazakh"
           ],
           [
            'link' => "vi|km",
            'code' => "km",
            'title' => "Khmer"
           ],
           [
            'link' => "vi|ko",
            'code' => "ko",
            'title' => "Korean"
           ],
           [
            'link' => "vi|ku",
            'code' => "ku",
            'title' => "Kurdish (Kurmanji)"
           ],
           [
            'link' => "vi|ky",
            'code' => "ky",
            'title' => "Kyrgyz"
           ],
           [
            'link' => "vi|lo",
            'code' => "lo",
            'title' => "Lao"
           ],
           [
            'link' => "vi|la",
            'code' => "la",
            'title' => "Latin"
           ],
           [
            'link' => "vi|lv",
            'code' => "lv",
            'title' => "Latvian"
           ],
           [
            'link' => "vi|lt",
            'code' => "lt",
            'title' => "Lithuanian"
           ],
           [
            'link' => "vi|lb",
            'code' => "lb",
            'title' => "Luxembourgish"
           ],
           [
            'link' => "vi|mk",
            'code' => "mk",
            'title' => "Macedonian"
           ],
           [
            'link' => "vi|mg",
            'code' => "mg",
            'title' => "Malagasy"
           ],
           [
            'link' => "vi|ms",
            'code' => "ms",
            'title' => "Malay"
           ],
           [
            'link' => "vi|ml",
            'code' => "ml",
            'title' => "Malayalam"
           ],
           [
            'link' => "vi|mt",
            'code' => "mt",
            'title' => "Maltese"
           ],
           [
            'link' => "vi|mi",
            'code' => "mi",
            'title' => "Maori"
           ],
           [
            'link' => "vi|mr",
            'code' => "mr",
            'title' => "Marathi"
           ],
           [
            'link' => "vi|mn",
            'code' => "mn",
            'title' => "Mongolian"
           ],
           [
            'link' => "vi|my",
            'code' => "my",
            'title' => "Myanmar (Burmese)"
           ],
           [
            'link' => "vi|ne",
            'code' => "ne",
            'title' => "Nepali"
           ],
           [
            'link' => "vi|no",
            'code' => "no",
            'title' => "Norwegian"
           ],
           [
            'link' => "vi|ps",
            'code' => "ps",
            'title' => "Pashto"
           ],
           [
            'link' => "vi|fa",
            'code' => "fa",
            'title' => "Persian"
           ],
           [
            'link' => "vi|pl",
            'code' => "pl",
            'title' => "Polish"
           ],
           [
            'link' => "vi|pt",
            'code' => "pt",
            'title' => "Portuguese"
           ],
           [
            'link' => "vi|pa",
            'code' => "pa",
            'title' => "Punjabi"
           ],
           [
            'link' => "vi|ro",
            'code' => "ro",
            'title' => "Romanian"
           ],
           [
            'link' => "vi|ru",
            'code' => "ru",
            'title' => "Russian"
           ],
           [
            'link' => "vi|sm",
            'code' => "sm",
            'title' => "Samoan"
           ],
           [
            'link' => "vi|gd",
            'code' => "gd",
            'title' => "Scottish Gaelic"
           ],
           [
            'link' => "vi|sr",
            'code' => "sr",
            'title' => "Serbian"
           ],
           [
            'link' => "vi|st",
            'code' => "st",
            'title' => "Sesotho"
           ],
           [
            'link' => "vi|sn",
            'code' => "sn",
            'title' => "Shona"
           ],
           [
            'link' => "vi|sd",
            'code' => "sd",
            'title' => "Sindhi"
           ],
           [
            'link' => "vi|si",
            'code' => "si",
            'title' => "Sinhala"
           ],
           [
            'link' => "vi|sk",
            'code' => "sk",
            'title' => "Slovak"
           ],
           [
            'link' => "vi|sl",
            'code' => "sl",
            'title' => "Slovenian"
           ],
           [
            'link' => "vi|so",
            'code' => "so",
            'title' => "Somali"
           ],
           [
            'link' => "vi|es",
            'code' => "es",
            'title' => "Spanish"
           ],
           [
            'link' => "vi|su",
            'code' => "su",
            'title' => "Sundanese"
           ],
           [
            'link' => "vi|sw",
            'code' => "sw",
            'title' => "Swahili"
           ],
           [
            'link' => "vi|sv",
            'code' => "sv",
            'title' => "Swedish"
           ],
           [
            'link' => "vi|tg",
            'code' => "tg",
            'title' => "Tajik"
           ],
           [
            'link' => "vi|ta",
            'code' => "ta",
            'title' => "Tamil"
           ],
           [
            'link' => "vi|te",
            'code' => "te",
            'title' => "Telugu"
           ],
           [
            'link' => "vi|th",
            'code' => "th",
            'title' => "Thai"
           ],
           [
            'link' => "vi|tr",
            'code' => "tr",
            'title' => "Turkish"
           ],
           [
            'link' => "vi|uk",
            'code' => "uk",
            'title' => "Ukrainian"
           ],
           [
            'link' => "vi|ur",
            'code' => "ur",
            'title' => "Urdu"
           ],
           [
            'link' => "vi|uz",
            'code' => "uz",
            'title' => "Uzbek"
           ],
           [
            'link' => "vi|vi",
            'code' => "vi",
            'title' => "Vietnamese"
           ],
           [
            'link' => "vi|cy",
            'code' => "cy",
            'title' => "Welsh"
           ],
           [
            'link' => "vi|xh",
            'code' => "xh",
            'title' => "Xhosa"
           ],
           [
            'link' => "vi|yi",
            'code' => "yi",
            'title' => "Yiddish"
           ],
           [
            'link' => "vi|yo",
            'code' => "yo",
            'title' => "Yoruba"
           ],
           [
            'link' => "vi|zu",
            'code' => "zu",
            'title' => "Zulu"
           ],
        ];
        foreach($array as $index => $item)
        {
            $menu_item = new \Harimayco\Menu\Models\MenuItems;
            $menu_item->label = $item['title'];
            $menu_item->content = $item['title'];
            $menu_item->link = $item['link'];
            $menu_item->menu = 8;
            $menu_item->depth = 0;
            $menu_item->sort = $index;
            $menu_item->parent = 0;
            $menu_item->icon = 'https://cdn.gtranslate.net/flags/svg/'. $item['code'] .'.svg';
            $menu_item->save();
        }*/
        return view('admin.setting.menu');
    }

    public function getThemeOption(){
        return view('admin.setting.theme-option',[
            'title' => 'Theme option',
            'url_post' => route('admin_theme_option.post'),
            'settings' => \App\Models\Setting::orderBy('sort')->get(),
        ]);
    }

    public function postThemeOption(Request $rq){
        $data = request()->all();
        // dd($data);
        $data_option = $data['header_option'];
        $i = 0;
        $list_option = [];
        // dd($data_option);
        if($data_option){
            foreach ($data_option as $key => $option) {
                $type = $key;
                foreach($option['name'] as $index => $item){
                    $content = htmlspecialchars($option['value'][$index]);
                    if($type == 'editor')
                        $content = htmlspecialchars($content);
                    $option_db = Setting::updateOrCreate(
                        [
                            'name'  => $item
                        ],
                        [
                            'content'   => $content,
                            'type'   => $type,
                            'sort'   => $i,
                        ]
                    );
                    $list_option[] = $option_db->id;
                    $i++;
                }
            }
        }
        //delete;
        Setting::whereNotIn('id', $list_option)->delete();
        Cache::forget('theme_option');
        $msg = "Option has been registered";
        $url= route('admin_theme_option');
        Helpers::msg_move_page($msg,$url);
    }

}
