<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

use App\Models\ShopLanguage;
use App\Admin\Models\AdminClient, App\Admin\Models\AdminClientCategory;

class AdminClientController extends Controller
{
    public $title_head = 'Mục thông tin';
    public $admin_view = 'admin.client';
    public $route_path = 'admin_client';
    public $languages;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->languages       = ShopLanguage::getListActive();
        \App::setLocale($this->languages->where('set_default', 1)->first()->code);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $categoriesTitle = AdminClientCategory::getListTitleAdmin();

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
        ];
        $posts = (new AdminClient)->getListAdmin($dataSearch);

        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'posts'            => $posts,
            'categoriesTitle'            => $categoriesTitle,
            'url_create'            => route($this->route_path .'.create'),
            'urlDeleteItem'            => route($this->route_path .'.delete'),
        ];

        return view($this->admin_view .'.index', $data);
    }

    public function create(){
        $categories = (new AdminClientCategory)->getTreeCategoriesAdmin();
        // dd($categories);

        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'categories'            => $categories,
            'url_post'            => route($this->route_path .'.post'),
        ];
        return view($this->admin_view .'.single', $data);
    }

    public function edit($id){
        $categories = (new AdminClientCategory)->getTreeCategoriesAdmin();
        $post = AdminClient::findorfail($id);
        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'post'            => $post,
            'categories'            => $categories,
            'url_post'            => route($this->route_path .'.post'),
        ];

        return view($this->admin_view .'.single', $data);
        
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
            'slug' => $slug,

            'gallery' => $data['gallery'] ?? '',
            'image' => $data['image'] ?? '',
            'cover' => $data['cover'] ?? '',
            'icon' => $data['icon'] ?? '',
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

        if($post_id == 0){
            $post = AdminClient::create($data_db);
            $post_id= $post->id;
        } else{
            $post = AdminClient::find($post_id);
            $post->update($data_db);

            $post->description()->delete();
            $post->categories()->detach();
        }

        //Insert category
        if ($category) {
            $post->categories()->attach($category);
        }

        //description
        $dataDes = [];
        foreach ($data['description'] as $code => $row) 
        {
            $dataDes = [
                'post_id' => (int)$post_id,
                'lang' => $code,
                'name' => $row['name'],
                'description' => htmlspecialchars($row['description']??''),
                'content' => htmlspecialchars($row['content'] ?? ''),
                'seo_title' => $row['seo_title'] ?? '',
                'seo_keyword' => $row['seo_keyword'] ?? '',
                'seo_description' => $row['seo_description'] ?? '',
            ];
            AdminClient::insertDescription($dataDes);
        }        
        //description

        if($save == 'apply'){
            $msg = "Client has been Updated";
            $url = route($this->route_path .'.edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route($this->route_path));
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
            AdminClient::destroy($arrID);
            
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }
    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return AdminClient::find($id);
    }
}
