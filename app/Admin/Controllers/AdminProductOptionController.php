<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

use App\Admin\Models\AdminShopOption;

class AdminProductOptionController extends Controller
{
    public $admin_path = 'admin.product_option';
    public $title_head;
    public $categories;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminShopOption $tableModel){
        $this->title_head = 'Tùy chọn đăng tin';
        $this->tableModel = $tableModel;
        $this->categories = (new AdminShopOption)->getTreeCategoriesAdmin();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $db = $this->tableModel->where('parent', 0);

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
            'url_action'  => route('admin_product.option_post'),
        ];

        return view($this->admin_path .'.index', $dataReponse);
    }

    public function create(){
        $dataReponse = [
            'title'  => $this->title_head . ' | Thêm mới',
            'categories'  => $this->categories,
            'url_action'  => route('admin_product.option_post'),
        ];
        return view($this->admin_path .'.single', $dataReponse);
    }

    public function edit($id){
        $post = $this->tableModel->findOrFail($id);

        if($post){

            $db = $this->tableModel->where('parent', 0);

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
                'url_action'  => route('admin_product.option_post'),
            ];

            return view($this->admin_path .'.index', $dataReponse);
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
                'unit' => $data['unit']??'',
                'parent' => $data['category']??0,
                'type' => $data['type']??'',
                'type_data' => $data['type_data']??'',
                'status' => $data['status']??0,
                'required' => $data['required']??0,
            ]
        );

        $post_id = $respons->id;


        $save = $data['submit'] ?? 'apply';


        if($save=='apply'){
            $msg = "Option method has been Updated";
            $url = route('admin_product.option_edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else
            return redirect(route('admin_product.option'));
    }

    public function delete($id)
    {
        $post = $this->tableModel->find($id);
        if($post)
        {
            $post->delete();
        }

        return redirect(route('admin_product.option'));
    }

    public function settingDelete()
    {
        $key = request('key');
        \App\Models\ShopPaymentMethodSetting::where('key', $key)->delete();
        return response()->json(['error' => 0, 'msg' => sc_language_render('action.update_success')]);
    }

    // ajax
    public function collectionPaymentMethod()
    {
        $data = request()->all();
        
        if(!empty($data['country']) && $data['country'] != '')
        {
            $country = end($data['country']);
            $dataRequest = [
                'amount'    => $data['amount']??0.5,
                'invoice_currency'    => $data['invoice_currency'],
                'customer_country'    => $country,
            ];
            $paymentMethods = (new \App\Services\TazapayService)->getPaymentMethods($dataRequest);
            // dd($paymentMethods);
            $view = view($this->admin_path .'.includes.payment-method', ['paymentMethods' => $paymentMethods])->render();
            return response()->json([
                'error' => 0,
                'messages'  => 'Success',
                'view'  => $view
            ]);
        }
        return response()->json([
            'error' => 1,
            'message'   => 'Please select country'
        ]);
    }
}
