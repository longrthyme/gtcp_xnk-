<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\ShopPaymentMethod;
use App\Models\ShopPaymentMethodItem;

class PaymentMethodItemController extends Controller
{
    public $admin_path = 'admin.shop-payment-method';
    public $title_head;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ShopPaymentMethodItem $tableModel){
        $this->title_head = 'Payment Method';
        $this->tableModel = $tableModel;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index($id){
        
        $db = $this->tableModel->where('method_id', $id);

        if(request()->has('keyword') && request()->keyword != ''){
            $keyword = request('keyword');
            $db = $db->where('name', 'like', '%'. $keyword .'%');
        }

        $posts = $db->orderByDesc('created_at')->paginate(20);


        $dataReponse = [
            'method'  => \App\Models\ShopPaymentMethod::find($id),
            'method_id'  => $id,
            'posts'  => $posts,
            'title'  => $this->title_head,
            'url_action'  => route('admin_payment_method.item_post'),
        ];

        return view($this->admin_path .'.method', $dataReponse);
    }

    public function edit($id){
        $post = $this->tableModel->findOrFail($id);
        if($post){
            $db = $this->tableModel->where('method_id', $post->method_id);

            if(request()->has('keyword') && request()->keyword != ''){
                $keyword = request('keyword');
                $db = $db->where('name', 'like', '%'. $keyword .'%');
            }

            $posts = $db->orderByDesc('created_at')->paginate(20);

            $dataReponse = [
                'method'  => \App\Models\ShopPaymentMethod::find($post->method_id),
                'post'  => $post,
                'posts'  => $posts,
                'title'  => $this->title_head,
                'url_action'  => route('admin_payment_method.item_post'),
            ];

            return view($this->admin_path .'.method', $dataReponse);
        }
    }

    protected function validator(array $data)
    {
        $validation_rules = array(
            'name' => 'required|max:255',
            'code' => 'required|max:255',
        );
        $messages = array(
            'name.required' => 'Enter Title',
            'name.max' => 'Title limit at 255 characters',
            'code.required' => 'Enter Code payment',
            'code.max' => 'Code payment limit at 255 characters',
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

        $country = $data['country']??[];

        $respons = $this->tableModel->updateOrCreate(
            [
                'id' => $data['id']??0,
            ],
            [
                'name' => $data['name'],
                'method_id' => $data['method_id'],
                'method_name' => $data['method_name'],
                
                'amount' => $data['amount']??0.5,
                'invoice_currency' => !empty($data['invoice_currency'])? json_encode($data['invoice_currency']) : '',
                'country_code' => count($country)? json_encode($country) : '',

                'code' => $data['code']??0,
                'image' => $data['image']??'',
                'hot' => $data['hot']??0,
                'status' => $data['status']??0,
                'fee' => $data['fee']??0,
                'created_at' => $data['created_at']??date('Y-m-d H:i'),
            ]
        );

        $post_id = $respons->id;

        $save = $data['submit'] ?? 'apply';

        if($save=='apply'){
            $msg = "Payment method has been Updated";
            $url = route('admin_payment_method.item_edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else
            return redirect(route('admin_payment_method.item', $data['method_id']));
    }

    public function delete($id)
    {
        $post = $this->tableModel->find($id);
        if($post)
        {
            $post->delete();
        }

        return redirect(route('admin_payment_method.item', $post->method_id));
    }
}
