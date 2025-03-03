<?php
namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RootAdminController;

use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image;

use App\Admin\Models\AdminPage;
use App\Models\ShopLanguage;

class PageController extends RootAdminController
{

    public $title_head = 'Trang';
    public $view_path = 'admin.page';
    public $languages;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->languages       = ShopLanguage::getListActive();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        // dd($categoriesTitle);
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
            'arrSort'     => $arrSort,
        ];
        $posts = (new AdminPage)->getListAdmin($dataSearch);

        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'posts'            => $posts,
            'url_create'            => route('admin_page.create'),
            'urlDeleteItem' => sc_route_admin('admin_page.delete'),
        ];

        return view($this->view_path .'.index', $data);
    }

    public function create(){
        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'url_post'            => route('admin_page.post'),
        ];
        return view($this->view_path .'.single', $data);
    }

    public function edit($id){
        $post = AdminPage::findorfail($id);
        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'post'            => $post,
            'url_post'            => route('admin_page.post'),
            'post_url'            => route('post.single', $post->slug),
        ];

        return view($this->view_path .'.single', $data);
    }

    public function post(Request $rq){
        $data = request()->all();
        $post_id = $data['id'];

        $langFirst = array_key_first($this->languages->toArray());

        $slug = $data['slug']??'';
        if($slug == '')
           $slug = Str::slug($data['description'][$langFirst]['name']);
        
        $save = $data['submit'] ?? 'apply';

        $data_db = array(
            'slug' => $slug,

            'image' => $data['image'] ?? '',
            'cover' => $data['cover'] ?? '',
            'icon' => $data['icon'] ?? '',
            'status' => $data['status'] ?? 0,
            'sort' => $data['sort'] ?? 0,
            'created_at' => $rq->created_at??date('Y-m-d H:i'),
        );

        if($post_id == 0){
            $respons = AdminPage::create($data_db);
            $post_id= $respons->id;
        } else{
            $respons = AdminPage::find($post_id)->update($data_db);
            $post = AdminPage::find($post_id);
            $post->descriptions()->delete();
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
            AdminPage::insertDescriptionAdmin($dataDes);
        }        
        //description

        if($save=='apply'){
            $msg = "Page has been Updated";
            $url = route('admin_page.edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_page'));
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
            AdminPage::destroy($arrID);
            
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }
    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return AdminPage::find($id);
    }
}
