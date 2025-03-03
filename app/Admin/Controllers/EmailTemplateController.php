<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

use App\Models\ShopEmailTemplate;

class EmailTemplateController extends Controller
{
    public $path_folder = 'admin.email_template';
    public $title_head = 'Email template';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $data = [
            'title_head'    => $this->title_head,
            'datas' => ShopEmailTemplate::orderByDesc('created_at')->paginate(20),
            'url_create'    => route('admin.email_template.create'),
            'urlDeleteItem' => sc_route_admin('admin.email_template.delete'),
        ];
        return view($this->path_folder .'.index', $data);
    }

    public function create(){
        $data = [
            'title_head'    => $this->title_head,
            'arrayGroup' => $this->arrayGroup(),
            'url_create'    => route('admin.email_template.create'),
            'urlDeleteItem' => sc_route_admin('admin.email_template.delete'),
        ];
        return view($this->path_folder.'.single', $data);
    }

    public function edit($id){
        $data = [
            'title_head'    => $this->title_head,
            'data' => ShopEmailTemplate::findorfail($id),
            'arrayGroup' => $this->arrayGroup(),
            'url_create'    => route('admin.email_template.create'),
            'urlDeleteItem' => sc_route_admin('admin.email_template.delete'),
        ];

        return view($this->path_folder . '.single', $data);
    }

    public function post(Request $rq){
        $data = request()->all();

        $arrayGroup = $this->arrayGroup();
        if($data['group'])
        {
            $data_db = array(
                'name'  => $arrayGroup[$data['group']],
                'subject'  => $data['subject']??'',
                'group'  => $data['group'],
                'text'  => htmlspecialchars($data['content']),
                'status'  => $data['status'] ?? 0,
                'created_at'  => $data['created_at'] ?? date('Y-m-d H:i'),
            );

            if($data['id'])
                $response = ShopEmailTemplate::find($data['id'])->update($data_db);
            else{
                $response = ShopEmailTemplate::create($data_db);
                $data['id'] = $response->id;
            }

            if($data['submit'] == 'apply'){
                $msg = "Success";
                $url = route('admin.email_template.edit', array($data['id']));
                Helpers::msg_move_page($msg, $url);
            }
            else{
                return redirect(route('admin.email_template'));
            }
        }
        return redirect()->back()->with(['error' => 'Vui lòng chọn Group']);
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
            ShopEmailTemplate::destroy($arrID);
            
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }
    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id)
    {
        return ShopEmailTemplate::find($id);
    }

    public function arrayGroup()
    {
        return  [
            'post_reject' => 'Gửi mail từ chối duyệt bài đăng',
            'register_at_checkout' => 'Gửi email đăng ký ở trang Checkout',
            'order_payment_success' => 'Gửi email thanh toán thành công cho admin',
            'order_payment_success_user' => 'Gửi email thanh toán thành công cho khách',
            'order_to_admin' => 'Gửi email đơn hàng cho Admin',
            'order_to_user' => 'Gửi email đơn hàng cho khách',
            'order_processing' => 'Gửi email đơn hàng Processing',
            'order_cancel' => 'Gửi email đơn hàng Cancel',
            'order_completed' => 'Gửi email đơn hàng Completed',
            'forgot_password' => "Gủi thông báo quên mật khẩu",
            'welcome_customer_sys' =>  'Gửi đăng ký thành công cho admin',
            'welcome_customer' =>  'Gửi đăng ký thành công cho khách',
            'contact_to_admin' =>  "Gửi thông báo liên hệ cho admin",
            'customer_verify' =>  "Gửi thông báo xác thực user",
            'customer_verify_admin' =>  "Gửi thông báo xác thực user tới Admin",

            'contact_baogia_to_user' =>  "Gửi yêu cầu báo giá tới chủ shop",
            'contact_baogia_success' =>  "Gửi yêu cầu báo giá thành công",
            'contact_baogia_admin' =>  "Gửi yêu cầu báo giá cho Admin",

            'customer_verify_reject' =>  "Gửi thông báo xác thực bị từ chối",
            'customer_verify_success' =>  "Gửi thông báo xác thực thành công",
            'customer_upgrade_success' =>  "Gửi thông Upgrade tài khoản thành công",

            'request_payment_success' =>  'Gửi email thanh toán đơn hàng thành công',
            // 'other' =>  trans('email.email_action.other'),
        ];
    }
}
