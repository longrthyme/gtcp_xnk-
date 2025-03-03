<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use Auth, DB, File, Image, Config;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

use App\Models\ShopLanguage;
use App\Models\ShopVideo;
use App\Models\ShopProduct;

class ShopVideoController extends Controller
{
    public $view = 'admin.shop-video';
    public $title_head;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
        $this->languages       = ShopLanguage::getListActive();
        $this->title_head = __('Video khóa học');
        \App::setLocale($this->languages->where('set_default', 1)->first()->code);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index($product_id, $id=0){
        $video_parents = (new ShopVideo)->getListAdmin([
            'parent'    => 0,
            'product_id'    => $product_id
        ]);
        $product = (new ShopProduct)->find($product_id);
        if($product)
        {
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
                'arrSort'     => $arrSort,
                'parent'     => 0,
                'product_id'    => $product_id
            ];
            $posts = (new ShopVideo)->getListAdmin($dataSearch);

            $data = [
                'title'            => $this->title_head,
                'languages'            => $this->languages,
                'posts'            => $posts,
                'product'            => $product,
                'video_parents'            => $video_parents,
                'url_create'            => route('admin_video.create'),
                'url_post'            => route('admin_video.post'),
                'total_item'            => $posts->count(),
                'urlDeleteItem'            => route('admin_video.delete'),
            ];
            
            return view($this->view .'.index', $data);
        }
        return redirect(sc_route('admin_product'));
    }

    public function edit($id){
        $langFirst = array_key_first($this->languages->toArray());

        $video_parents = (new ShopVideo)->getListAdmin([
            'parent'    => 0
        ]);

        $post = ShopVideo::findorfail($id);

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
            'product_id' => $post->product_id,
            'sort_order'  => $sort_order,
            'arrSort'     => $arrSort,
            'parent'     => 0,
        ];
        $posts = (new ShopVideo)->getListAdmin($dataSearch);

        $product = (new ShopProduct)->find($post->product_id);
        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'langFirst'            => $langFirst,
            'post'            => $post,
            'posts'            => $posts,
            'product'            => $product,
            
            'video_parents'            => $video_parents,
            'url_create'            => route('admin_video.create'),
            'url_post'            => route('admin_video.post'),
            'total_item'            => $posts->count(),
            'urlDeleteItem'            => route('admin_video.delete'),
        ];

        return view($this->view .'.index', $data);

    }

    public function post(){
        $data = request()->all();
        $post_id = $data['id'];

        $langFirst = array_key_first($this->languages->toArray());

        $category   = $data['category'] ?? [];
        $slug       = $data['slug']??'';
        $galleries  = $data['gallery'] ?? '';
        $save       = $data['submit'] ?? 'apply';
        $data_db    = [
            'product_id' => $data['product_id'],
            'parent_id' => $data['parent_id']??0,
            'slug' => $slug,
            'file' => $data['file_url']??'',

            'image' => $data['image'] ?? '',
            'status' => $data['status'] ?? 0,
            'sort' => $data['sort'] ?? 0,
            'created_at' => $data['created_at']??date('Y-m-d H:i'),
        ];

        if($slug == '')
           $data_db['slug'] = Str::slug($data['description'][$langFirst]['name']);
        
        if($galleries !='' )
        {
            $galleries = array_filter($galleries);
            $data_db['gallery'] = $galleries ? serialize($galleries) : '';
        }

        if($post_id == 0)
        {
            $post = ShopVideo::create($data_db);
            $post_id= $post->id;
        }
        else
        {
            $post = ShopVideo::find($post_id);
            $post->update($data_db);

            $post->description()->delete();
            $post->categories()->detach();
        }

        //Insert category
        if ($category) {
            $post->categories()->attach($category);
        }

        // upload file zip
        if(!empty($data['file_zip']))
        {
            $public_folderPath = 'upload/study/lesson/';

            $dir = $public_folderPath . $post_id;
            if (is_dir('upload/study/') === false) {
                mkdir('upload/study/');
            }
            if (is_dir($public_folderPath) === false) {
                mkdir($public_folderPath);
            }
            if (is_dir($dir) === false) {
                mkdir($dir);
            }

            $zip = new ZipArchive;
            $file_zip = request()->file('file_zip')->store($dir, 'public');
            

            $zipFile = $zip->open(Storage::disk('public')->path($file_zip));
            if ($zipFile === TRUE) {
                $zip->extractTo($dir); 
                $zip->close();
                Storage::disk('public')->delete($file_zip);

                ShopVideo::find($post_id)->update([
                    'file'  => $dir. '/story.html'
                ]);
            }
        }
        // upload file zip

        //description
        $dataDes = [];
        foreach ($data['description'] as $code => $row) 
        {
            $dataDes = [
                'post_id' => (int)$post_id,
                'lang' => $code,
                'name' => $row['name'],
                'duration' => $row['duration']??'',
                'description' => htmlspecialchars($row['description']??''),
                'content' => htmlspecialchars($row['content'] ?? ''),
                'seo_title' => $row['seo_title'] ?? '',
                'seo_keyword' => $row['seo_keyword'] ?? '',
                'seo_description' => $row['seo_description'] ?? '',
            ];
            ShopVideo::insertDescription($dataDes);
        }        
        //description

        if($save == 'apply'){
            $msg = "Product has been Updated";
            $url = route('admin_video.edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_video', ['product_id' => $data['product_id']]));
        }
    }

    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.method_not_allow')]);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            $arrDontPermission = [];
            foreach ($arrID as $key => $id) {
                if (!$this->checkPermisisonItem($id)) {
                    $arrDontPermission[] = $id;
                }
            }
            if (count($arrDontPermission)) {
                return response()->json(['error' => 1, 'msg' => sc_language_render('admin.remove_dont_permisison') . ': ' . json_encode($arrDontPermission)]);
            }
            ShopProduct::destroy($arrID);
            
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }
    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return ShopProduct::find($id);
    }
}
