<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Gornymedia\Shortcodes\Facades\Shortcode;
use Carbon\Carbon;

use App\Models\Page;
use App\Models\ShopProduct;

class PageController extends Controller {
    use \App\Traits\LocalizeController;
    
    public $data = [];


    // $this->templatePath
    public function index()
    {
        sc_statistical_log();

        $page = (new Page)->getDetail(93);

        $dataReponse = [
            'layout_page'   => 'home',
            'page'   => $page,
            'seo_title' => $page->seo_title!=''? $page->seo_title : $page->name,
            'seo_image' => $page->image,
            'seo_description'   => $page->seo_description ?? '',
            'seo_keyword'   => $page->seo_keyword ?? '',
        ];

        // dd('fda');
        return view($this->templatePath .'.home', $dataReponse)->compileShortcodes();
    }

    public function page($slug) {
        sc_statistical_log();
        $this->localized();

        if ('home' == $slug || 'trangchu' == $slug) {
            return $this->index();
        }

        $page = (new Page)->getDetail($slug, 'slug');
        if($page)
        {
            $dataReponse = [
                'layout_page'   => 'home',
                'page'   => $page,
                'seo_title' => $page->seo_title!=''? $page->seo_title : $page->title,
                'seo_image' => $page->image,
                'seo_description'   => $page->seo_description ?? '',
                'seo_keyword'   => $page->seo_keyword ?? '',
            ];

            $templateName = $this->templatePath .'.page.' . $slug;
            if (View::exists($templateName)) {

                return view($templateName, $dataReponse)->compileShortcodes();
            } else {
                return view($this->templatePath .'.page.index', $dataReponse)->compileShortcodes();
            }
        }
        else {
            return (new \App\Http\Controllers\NewsController)->categoryDetail($slug);
        }
    }

    public function project($slug)
    {
        return \App::call('App\Http\Controllers\ProjectController@index',  [
            "slug" => $slug
        ]);
    }

    public function listLocation()
    {
        $data = array(
            'mienbac'   => 'Miền Bắc',
            'mientrung'   => 'Miền Trung',
            'miennam'   => 'Miền Nam'
        );
        return $data;
    }

}
