<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Helpers;
use Illuminate\Support\Str;

use App\Admin\Models\AdminClientCategory;
use App\Models\ShopLanguage;

class AdminClientCategoryController extends Controller
{
    public $title_head = 'Danh mục tin tức';
    public $admin_view = 'admin.client-category';
    public $route_path = 'admin_client.category';
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
        // $data_category = PostCategory::orderByDESC('id')->get();
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
        $posts = (new AdminClientCategory)->getCategoryListAdmin($dataSearch);
        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'posts'            => $posts,
            'url_create'            => route($this->route_path .'_create'),
            'urlDeleteItem'            => route($this->route_path .'_delete'),
        ];
        return view($this->admin_view .'.index', $data);
    }

    public function create(){
        $categories = (new AdminClientCategory)->getTreeCategoriesAdmin();
        $data = [
            'title'            => $this->title_head,
            'categories'       => $categories,
            'languages'        => $this->languages,
            'url_post'         => route($this->route_path .'_post'),
        ];
        return view($this->admin_view .'.single', $data);
    }

    public function edit($id){
        $post = AdminClientCategory::find($id);
        $categories = (new AdminClientCategory)->getTreeCategoriesAdmin();
        if($post){
            $data = [
                'title'            => $this->title_head,
                'languages'            => $this->languages,
                'post'            => $post,
                'categories'            => $categories,
                'url_post'            => route($this->route_path .'_post'),
            ];
            // dd($data);
            return view($this->admin_view .'.single', $data);
        } else{
            return view('404');
        }
    }

    public function post(){
        $data = request()->all();
        //id post
        $post_id = $data['id']??0;

        $langFirst = array_key_first($this->languages->toArray());
        // dd($langFirst);

        $slug = $data['slug']??'';
        if($slug == '')
           $slug = Str::slug($data['description'][$langFirst]['name']);

        $save = $data['submit'] ?? 'apply';

        //update
        $data_db = array(
            'slug' => $slug,
            'parent' => $data['category_parent'],

            'image' => $data['image'] ?? '',
            'cover' => $data['cover'] ?? '',
            'icon' => $data['icon'] ?? '',
            'sort' => $data['sort'] ?? 0,
            'status' => $data['status'] ?? 0
        );

        if($post_id)
        {
            $category = AdminClientCategory::find($post_id); 
            $category->update($data_db);
            $category->description()->delete();
        }
        else
        {
            $respons = AdminClientCategory::create($data_db);
            $post_id = $respons->id;
        }

        //description
        $dataDes = [];
        foreach ($data['description'] as $code => $row) 
        {
            $dataDes = [
                'category_id' => (int)$post_id,
                'lang' => $code,
                'name' => $row['name'],
                'description' => htmlspecialchars($row['description']??''),
                'content' => htmlspecialchars($row['content'] ?? ''),
                'seo_title' => $row['seo_title'] ?? '',
                'seo_keyword' => $row['seo_keyword'] ?? '',
                'seo_description' => $row['seo_description'] ?? '',
            ];
            AdminClientCategory::insertDescription($dataDes);
        }
        //description

        if($save=='apply')
        {
            $msg = "Catagory client has been Updated";
            $url = route($this->route_path .'_edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else
            return redirect(route('admin_client.category'));
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
            ClientCategory::destroy($arrID);
            
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }
    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return ClientCategory::find($id);
    }
}
