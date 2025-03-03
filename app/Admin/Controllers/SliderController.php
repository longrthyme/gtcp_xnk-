<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Helpers;
use Illuminate\Support\Str;

use App\Admin\Models\AdminSlider;
use App\Models\ShopLanguage;

class SliderController extends Controller
{
    public $title_head = 'Slider';
    public $view_path = 'admin.slider';
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
        $sort_order  = request('sort_order') ?? 'id__desc';

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
            'slider_id'     => 0,
        ];
        $posts = (new AdminSlider)->getListAdmin($dataSearch);

        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'posts'            => $posts,
            'url_action'            => route('admin_slider.create'),
        ];

        return view($this->view_path .'.index', $data);
    }

    public function create(){
        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'url_action'            => route('admin_slider.post'),
        ];
        return view($this->view_path .'.single', $data);
    }

    public function edit($id){
        $post = AdminSlider::findorfail($id);
        $data = [
            'title'            => $this->title_head,
            'languages'            => $this->languages,
            'post'            => $post,
            'sliders'            => (new AdminSlider)->getListAdmin(['slider_id' => $id, 'sort_order' => 'order__asc']),
            'url_action'            => route('admin_slider.post'),
        ];

        return view($this->view_path .'.single', $data);
    }

    public function post(Request $rq){
        
        $data = request()->all();
        $post_id = $data['id'];

        $save = $data['submit'] ?? 'apply';

        $data_db = array(
            
            'status' => $data['status'] ?? 0,
            'created_at' => $rq->created_at??date('Y-m-d H:i'),
        );

        if($post_id == 0){
            $respons = AdminSlider::create($data_db);
            $post_id= $respons->id;
        } else{
            $post = AdminSlider::find($post_id);
            $post->update($data_db);
            $post->description()->delete();
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
            ];
            AdminSlider::insertDescription($dataDes);
        }
        // dd($dataDes);
        
        //description

        if($save=='apply'){
            $msg = "Slider has been Updated";
            $url = route('admin_slider.edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_slider'));
        }
    }

    public function editSlider(Request $request)
    {
        $id = (int)$request->id ?? 0;
        $parent = $request->parent ?? 0;

        if($id)
        {
            $slider = AdminSlider::findorfail($id);
            // dd($slider);
            $dataResponse = [
                'title_head' => 'Sửa slider',
                'slider'    => $slider,
                'parent'    => $parent,
                'languages'            => $this->languages,
            ];
        }
        else
        {
            $dataResponse = [
                'title_head' => 'Thêm slider',
                'parent'    => $parent,
                'languages'            => $this->languages,
            ];
        }

        return response()->json([
            'view'  => view($this->view_path .'.includes.form', $dataResponse)->render()
        ]);
    }

    public function insertSlider(Request $request)
    {
        $id = $request->id ?? 0;
        $parent = $request->slider_id ?? 0;
        $data = $request->all();
        // $data['description'] = htmlspecialchars($data['description']);

        if($id == 0){
            $slider_end = AdminSlider::where('slider_id', $parent)->orderby('order', 'desc')->first();
            if($slider_end)
                $data['order'] = (int)$slider_end->order + 1;
            else
                $data['order'] = 0;
        }
        else
        {
            AdminSlider::find($id)->description()->delete();
        }

        $data_db = [
            'slider_id' => $parent,
            'link' => $data['link'] ?? '',
            'video' => $data['video'] ?? '',
            'order' => $data['order'] ?? 0,
            'status' => $data['status'] ?? 0,
            'src' => $data['src'] ?? '',
        ];
        
        $slider = AdminSlider::updateOrCreate(
            ['id'=> $id],
            $data_db
        );

        //description
        // dd($data['description']);
        $dataDes = [];
        foreach ($data['description'] as $code => $row) 
        {
            $dataDes = [
                'post_id' => (int)$slider->id,
                'lang' => $code,
                'name' => $row['name'],
                'description' => htmlspecialchars($row['description']??''),
                'content' => htmlspecialchars($row['content'] ?? ''),
            ];
            AdminSlider::insertDescription($dataDes);
        }
        // dd($dataDes);
        
        //description

        // $sliders = (new AdminSlider)->getListAdmin(['slider_id' => $parent]);
        $sliders = (new AdminSlider)->getListAdmin(['slider_id' => $parent, 'sort_order' => 'order__asc']);

        $view = view($this->view_path .'.includes.slider-items', ['sliders'=>$sliders])->render();
        return response()->json([
            'view'  => $view
        ]);
        
    }
    

    public function deleteSlider(Request $request)
    {
        $id = $request->id ? $request->id : 0;
        if($id){
            $slider = AdminSlider::findorfail($id);
            $slider_id = $slider->slider_id;
            $slider->delete();

            $sliders = AdminSlider::where('slider_id', $slider_id)->orderby('order', 'asc')->get();
            $view = view($this->view_path .'.includes.slider-items', ['sliders'=>$sliders])->render();
            return response()->json([
                'view'  => $view
            ]);
        }
    }
    public function updateSort()
    {
        $sliders = request()->slider;
        
        foreach ($sliders as $key => $item) {
            AdminSlider::find($item)->update(['order'=> $key]);
        }
        return response()->json([
            'error' => 0,
            'msg'   => 'Success'
        ]);
    }
}
