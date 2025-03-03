<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Page;
use App\Models\PostCategory ;
use Gornymedia\Shortcodes\Facades\Shortcode;

class NewsController extends Controller
{
    use \App\Traits\LocalizeController;
    
    public $data = [];
    
    public function index() {
        return $this->categoryDetail('news');
    }
    
    public function newsDetail($slug)
    {
        $news = (new Post)->getDetail($slug, $type = 'slug');

        $category_last = $news->categories->last();
        $category = (new PostCategory)->getDetail($category_last->id);
        $news_featured = (new Post)->setCategory($category_last->id)->getList([
            'limit' => 6
        ]);
        $post_lastests = (new Post)->getList([
            'limit' => 6
        ]);

        $dataReponse = [
            'seo_title' => $news->seo_title??$news->name,
            'seo_description' => $news->seo_description??'',
            'seo_keyword' => $news->seo_keyword??'',
            'image' => $news->image??'',
            'category' => $category,
            'news' => $news,
            'news_featured' => $news_featured,
            'post_lastests' => $post_lastests,
        ];
        
        return view('theme.news.single', $dataReponse)->compileShortcodes();;
    }
    
    public function categoryDetail($slug)
    {
        $category = (new PostCategory)->getDetail($slug, $type = 'slug');
        if($category)
        {            
            $news = (new Post)->setCategory($category->id)->getList([]);

            $dataReponse = [
                'seo_title' => $category->seo_title??$category->name,
                'seo_description' => $category->seo_description??'',
                'seo_keyword' => $category->seo_keyword??'',
                'seo_image' => $category->image,
                'image' => $category->image??'',
                'category' => $category,
                'categories' => (new PostCategory)->getList([]),
                'news' => $news,
            ];

            if (\View::exists($this->templatePath .'.news.' . $category->slug))
            {
                $page = request('page')??1;
                $files = glob(public_path() .'/excel-render/*.html');
                
                if(isset($files[$page-1]))
                    $dataReponse['html'] = file_get_contents($files[$page-1]);
                $dataReponse['files'] = $files;
                if(request()->ajax())
                {
                    return response()->json([
                        'error' => 0,
                        'html' => $dataReponse['html']??'',
                    ]);
                }
                else
                    return view($this->templatePath .'.news.' . $category->slug, $dataReponse)->compileShortcodes();
            }
            else
                return view($this->templatePath .'.news.index', $dataReponse)->compileShortcodes();
        }
        else
            return $this->newsDetail($slug);
    }
}
