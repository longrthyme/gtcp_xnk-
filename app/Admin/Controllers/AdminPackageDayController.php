<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

use App\Admin\Models\AdminPackageDay;

class AdminPackageDayController extends Controller
{
    public $admin_path = 'admin.package.day';
    public $title_head;
    public $categories;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminPackageDay $tableModel){
        $this->title_head = 'Danh sách thời gian của gói';
        $this->tableModel = $tableModel;
        $this->categories = (new AdminPackageDay)->getTreeCategoriesAdmin();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $db = $this->tableModel;

        if(request()->has('keyword') && request()->keyword != ''){
            $keyword = request('keyword');
            $db = $db->where('name', 'like', '%'. $keyword .'%');
        }

        $posts = $db->orderBy('sort', 'asc')->get();

        // dd($this->categories);

        $dataReponse = [
            'posts'  => $posts,
            'title'  => $this->title_head,
            'categories'  => $this->categories,
            'url_action'  => route('admin_package.day_post'),
        ];

        return view($this->admin_path, $dataReponse);
    }

    public function edit($id){
        $post = $this->tableModel->findOrFail($id);

        if($post){

            $db = $this->tableModel;

            if(request()->has('keyword') && request()->keyword != ''){
                $keyword = request('keyword');
                $db = $db->where('name', 'like', '%'. $keyword .'%');
            }

            $posts = $db->orderBy('sort', 'asc')->get();

            $dataReponse = [
                'post'  => $post,
                'posts'  => $posts,
                'categories'  => $this->categories,
                'title'  => $this->title_head,
                'url_action'  => route('admin_package.day_post'),
            ];

            return view($this->admin_path, $dataReponse);
        }
    }

    protected function validator(array $data)
    {
        $validation_rules = array(
            'name' => 'required|max:255',
        );
        $messages = array(
            'name.required' => 'Enter Title',
            'name.max' => 'Title limit at 255 characters',
        );

        return Validator::make($data, $validation_rules, $messages);
    }

    public function store(Request $rq){
        $user_admin = auth()->user();
        $data = request()->all();
        $post_id = $data['id'];

        $validator = $this->validator($data);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $respons = $this->tableModel->updateOrCreate(
            [
                'id' => $data['id']??0,
            ],
            [
                'name' => $data['name'],
                'day' => $data['day']??'',
                'type' => $data['type']??'',
                'qty' => $data['qty']??0,
                'status' => $data['status']??0,
            ]
        );

        $post_id = $respons->id;


        $save = $data['submit'] ?? 'apply';


        if($save=='apply'){
            $msg = "Day method has been Updated";
            $url = route('admin_package.day_edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else
            return redirect(route('admin_package.day'));
    }

    public function delete($id)
    {
        $post = $this->tableModel->find($id);
        if($post)
        {
            $post->delete();
        }

        return redirect(route('admin_package.day'));
    }

}
