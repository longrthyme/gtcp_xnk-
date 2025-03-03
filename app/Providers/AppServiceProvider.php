<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Harimayco\Menu\Facades\Menu;
use Illuminate\Support\Facades\View;
use Gornymedia\Shortcodes\Facades\Shortcode;

use App\Models\ShopCurrency;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\Post;
use App\Models\Page;
use App\Models\Slider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->registerRouteMiddleware();
        $this->loadViewsFrom(base_path('/resources/views/admin'), 'admin');
    }   

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // dd(glob(app_path().'/Libraries/Helpers/*.php'));
        foreach (glob(app_path() .'/Libraries/Helpers/*.php') as $filename) {
            require_once $filename;
        }
        
        view()->share('templatePath', env('APP_THEME', 'theme'));
        view()->share('templateFile', env('APP_THEME', 'theme'));
        view()->share('templateVer', env('THEME_VER', '1.00'));
        view()->share('templatePathAdmin', 'admin::');

        view()->share('modelCurrency', (new ShopCurrency));
        view()->share('modelProduct', (new ShopProduct));
        view()->share('modelCategory', (new ShopCategory));
        view()->share('modelPost', (new Post));
        view()->share('modelPage', (new Page));
        view()->share('modelSlider', (new Slider));
        view()->share('modelPackage', (new \App\Models\Package));

        view()->share('modelClient', (new \App\Models\Client));
        view()->share('modelClientCategory', (new \App\Models\ClientCategory));
        
        Paginator::useBootstrap();
        // $this->bootCustom();

        //
        Shortcode::add('page', function($atts, $id, $style = 1, $slogan="")
        {
            $data = Shortcode::atts([
                'id' => $id,
                'style' => $style,
                'slogan' => $slogan,
            ], $atts);

            $file = 'shortcode/page';
            
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('slider', function($atts, $id, $items=3) 
        {
            $data = Shortcode::atts([
                'id' => $id,
                'items' => $items
            ], $atts);

            $file = 'shortcode/slider' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        //
        Shortcode::add('partner', function($atts, $id, $limit=10) 
        {
            $data = Shortcode::atts([
                'id' => $id,
                'limit' => $limit
            ], $atts);

            $file = 'shortcode/partner' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('service', function($atts) 
        {
            $data = Shortcode::atts([
            ], $atts);

            $file = 'shortcode/service' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('client_category', function($atts, $id, $limit=3) 
        {
            $data = Shortcode::atts([
                'id' => $id,
                'limit' => $limit
            ], $atts);

            $file = 'shortcode/client-category' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('filter', function($atts, $show_category=0)
        {
            $data = Shortcode::atts([
                'show_category' => $show_category
            ], $atts);

            $file = 'shortcode/filter' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('category_home', function($atts, $menu_slug='', $title="", $subtitle="") 
        {
            $data = Shortcode::atts([
                'menu_slug' => $menu_slug,
                'title' => $title,
                'subtitle' => $subtitle
            ], $atts);

            $file = 'shortcode/category_home' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('product_new', function($atts, $category_id=0, $limit=4, $title="")
        {
            $data = Shortcode::atts([
                'category_id' => $category_id,
                'limit' => $limit,
                'title' => $title
            ], $atts);

            $file = 'shortcode/product_new' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('product', function($atts, $category_id=0, $limit=4, $title="", $post_type='', $col='')
        {
            $data = Shortcode::atts([
                'category_id' => $category_id,
                'limit' => $limit,
                'title' => $title,
                'post_type' => $post_type,
                'col' => $col,
            ], $atts);

            $file = 'shortcode/product' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('contact', function($atts, $title="", $subtitle="") 
        {
            $data = Shortcode::atts([
                'title' => $title,
                'subtitle' => $subtitle,
            ], $atts);

            $file = 'shortcode/contact' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('keyword', function($atts, $menu="")
        {
            $data = Shortcode::atts([
                'menu' => $menu,
            ], $atts);

            $file = 'shortcode/keyword' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('logistic', function($atts)
        {
            $data = Shortcode::atts([
            ], $atts);

            $file = 'shortcode/logistic' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('van-chuyen', function($atts)
        {
            $data = Shortcode::atts([
            ], $atts);

            $file = 'shortcode/van-chuyen' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('yeu-cau-chao-gia', function($atts)
        {
            $data = Shortcode::atts([
            ], $atts);

            $file = 'shortcode/yeu-cau-chao-gia' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, $data);
            }
        });
        //
        Shortcode::add('banner', function($atts, $slider_id) 
        {
            $data = Shortcode::atts([
                'slider_id' => $slider_id
            ], $atts);

            $file = 'shortcode/banner' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        //
        Shortcode::add('gianhang', function($atts, $type='') 
        {
            $data = Shortcode::atts([
                'type' => $type
            ], $atts);

            $file = 'shortcode/gianhang' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }
    }


    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'currency' => \App\Http\Middleware\Currency::class
    ];

    public function bootCustom()
    {
        // view()->share('blocksContent', sc_store_block());
    }
}
