<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RootAdminController;

use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;

use App\Admin\Models\AdminShopCategory;
use App\Models\ShopLanguage;

class AdminCategoryController extends RootAdminController
{
    public $view = 'admin.product-category';

    public $title_head = 'Danh mục tin';
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
            'parent'     => 0,
        ];
        $data_category = (new AdminShopCategory)->getCategoryListAdmin($dataSearch);
        // dd($data_category);

        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'data_category'            => $data_category,
            'url_create'            => route('admin_product.category_create'),
            'urlDeleteItem'            => route('admin_product.category_delete'),
        ];

        return view($this->view .'.index', $data);
    }

    public function create(){
        $data = [
            'title'            => 'Thêm danh mục',
            'languages'            => $this->languages,
            'categories' => (new AdminShopCategory)->getTreeCategoriesAdmin(),
            'url_post'   => route('admin_product.category_post'),
        ];

        return view($this->view .'.single', $data);
    }

    public function edit($id){
        $join_option = \App\Models\ShopProductCategory::where('category_id', $id)->get();
        $category_variable = [];
        foreach ($join_option as $value) {
            $category_variable[] = $value->variable_id;
        }
        $post_category = AdminShopCategory::findorfail($id);
    
        $data = [
            'title'            => 'Sửa danh mục tin',
            'languages'            => $this->languages,
            'post'            => $post_category,
            'categories' => (new AdminShopCategory)->getTreeCategoriesAdmin(),
            'category_variable' => $category_variable,
            'url_post'   => route('admin_product.category_post'),
            'post_url'            => route('product', ['slug' => $post_category->slug]),
        ];
        // dd($data);

        return view($this->view .'.single', $data);
        
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
            'icon' => $data['icon'] ?? '',
            'sort' => $data['sort'] ?? 0,
            'status' => $data['status'] ?? 0,
            'created_at'    => $data['created_at']??date('Y-m-d H:i')
        );

        if($post_id)
        {
            $category = AdminShopCategory::find($post_id); 
            $category->update($data_db);
            $category->descriptions()->delete();
        }
        else
        {
            $respons = AdminShopCategory::createAdmin($data_db);
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
            AdminShopCategory::insertDescriptionAdmin($dataDes);
        }
        //description

        if($save=='apply')
        {
            $msg = "Cataory post has been Updated";
            $url = route('admin_product.category_edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else
            return redirect(route('admin_product.category'));
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
            AdminShopCategory::destroy($arrID);
            
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }
    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return AdminShopCategory::find($id);
    }
}
