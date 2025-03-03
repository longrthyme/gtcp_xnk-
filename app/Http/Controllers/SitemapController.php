<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\WebService;
use App\Libraries\Helpers;
use Response;
use File;

use App\Jobs\JobSitemap;

class SitemapController extends Controller
{
    public function index()
    {
        /*$job_sitemap = new JobSitemap();
        dispatch($job_sitemap);*/

        $pages = (new \App\Models\Page)->getListData()->where('status', 1)->get();

        $categories = (new \App\Models\ShopCategory)->getListData()->where('status', 1)->get();
        $products = (new \App\Models\ShopProduct)->getListData()->where('status', 1)->get();
        $posts = (new \App\Models\Post)->getListData()->where('status', 1)->get();
        $postCategories = (new \App\Models\PostCategory)->getListData()->where('status', 1)->get();

        // dd('fdfad');
        
        $view = view('sitemap.index', [
                'datas' => [$pages, $categories, $products, $posts, $postCategories]
            ])->render();
        File::put(public_path().'/sitemap.xml', '<?xml version="1.0" encoding="UTF-8"?>'.$view);

        return redirect(url('sitemap.xml'));
    }

}
