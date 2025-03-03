<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserVerify;

use App\Exports\CustomerExport;
use App\Exports\OrderExport;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\UserRole;
use App\Models\LocationProvince;
use App\ShoppingCart;

class UserController extends Controller
{

    public $data = [];
    public $admin_path = 'admin.users';
    public $title_head;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->title_head = __('Thành viên');
    }

	public function index(){
        $db = new User;
        
        if(request('keyword'))
        {
            $keyword = request('keyword');
            $db = $db->where(function($query) use($keyword){
                return $query->where('fullname', 'like', "%$keyword%")->orWhere('email', 'like', "%$keyword%");
            });
        }
        $data_user = $db->orderBy('created_at', 'desc')->get();
        
        $dataReponse = [
            'users'  => $data_user,
            'title'  => $this->title_head,
            'url_create'  => route('admin_user.create'),
        ];

        return view($this->admin_path .'.index', $dataReponse);
    }

    public function exportCustomer(Request $rq){
        return (new CustomerExport())->download('customer.xlsx');
    }

    public function create(){
        $dataReponse = [
            'title'  => $this->title_head . ' | Thêm mới',
            'user_roles'  => UserRole::get(),
            'provinces'  => LocationProvince::get(),
            'url_action'  => route('admin_user.post'),
        ];
        return view($this->admin_path .'.detail', $dataReponse);
    }

    public function userDetail($id){
    	$user = User::find($id);
        $user_verify = UserVerify::where('user_id', $id)->first();
        if($user){
            $dataReponse = [
                'user'  => $user,
                'user_verify'  => $user_verify,
                'title'  => $this->title_head,
                'user_roles'  => UserRole::get(),
                'provinces'  => LocationProvince::get(),
                'url_action'  => route('admin_user.post'),
            ];

            return view($this->admin_path .'.detail', $dataReponse);
        } else{
            return view('404');
        }
    }

    public function post(Request $request){
    	$id = $request->id;
        $user = User::find($id);
        $change_pass = $request->check_pass ?? 0;

        if($change_pass){
            $this->validate($request,[
                'email' => 'required|unique:"'.User::class.'",email,' . $id . '',
                'password'      => 'required|confirmed',
                'fullname'          => 'required',
            ],[
                'email.required' => 'Địa chỉ Email không được trống',
                'email.email' => 'Địa chỉ Email không đúng định dạng',
                'email.unique' => 'Địa chỉ Email đã tồn tại',
                'password.required' => 'Hãy nhập mật khẩu',
                'password.confirmed' => 'Xác nhận mật khẩu không đúng',
                'fullname.required' => 'Tên không được trống',
            ]);
        }
        else{
            $this->validate($request,[
                'email' => 'required|string|max:50|unique:"'.User::class.'",email,' . $id . '',
                'fullname'          => 'required',
            ],[
                'email.required' => 'Hãy nhập vào địa chỉ Email',
                'email.email' => 'Địa chỉ Email không đúng định dạng',
                'email.unique' => 'Địa chỉ Email đã tồn tại',
                'fullname.required' => 'Tên không được trống',
            ]);
        }

        $data = request()->all();    

        $dataUpdate = array(
            'about_me' => htmlspecialchars($data['about_me']??''),
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'address' => $data['address'] ?? '',
            'province' => $data['state'] ?? '',
            'district' => $data['slt_district'] ?? '',
            'ward' => $data['slt_ward'] ?? '',
            'avatar' => $data['avatar'],
            'phone' => $data['phone']??'',
            'status' => $data['status']??0,
            'type' => $data['type']??0,
            'role' => $data['role']??0,
            'account_type' => $data['account_type']??0,
        );

        if(!empty($data['birthday']))
        {
            $birthday = date('Y-m-d', strtotime($data['birthday']));
            $dataUpdate['birthday']  = $birthday;
        }
        if(!empty($data['other_name']))
            $dataUpdate['other_name']  = $data['other_name'];
        if(!empty($data['job']))
            $dataUpdate['job']  = $data['job'];
        if(!empty($data['company']))
            $dataUpdate['company']  = $data['company'];
        if(!empty($data['cccd']))
            $dataUpdate['cccd']  = $data['cccd'];
        if(!empty($data['cccd_date']))
        {
            $cccd_date = date('Y-m-d', strtotime($data['cccd_date']));
            $dataUpdate['cccd_date']  = $cccd_date;
        }
        if(!empty($data['cccd_place']))
            $dataUpdate['cccd_place']  = $data['cccd_place'];
        if(!empty($data['mst']))
            $dataUpdate['mst']  = $data['mst'];
        if(!empty($data['website']))
            $dataUpdate['website']  = $data['website'];

        if(!empty( $data['password'] )){
            $dataUpdate['password']  = bcrypt($data['password']);
        }
        if($id)
        {
            $respons = User::where("id", $id)->update($dataUpdate);
        }
        else
        {
            $data['password'] = $data['password'] ?? '123456';
            $dataUpdate['password']  = bcrypt($data['password']);
            $user_screate = User::create($dataUpdate);
            $id = $user_screate->id;
        }

        $save = $request->submit;
        if($save=='apply'){
            $msg = "User has been Updated";
            $url = route('admin_user.edit', array($id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_user'));
        }
    }

    public function deleteUser($id)
    {
        $loadDelete = User::find($id)->delete();
        $msg = "Customer account has been Delete";
        $url = route('admin_user');
        Helpers::msg_move_page($msg,$url);
    }

    function verify()
    {
        $users = (new UserVerify)->with('getUser')->whereHas('getUser', function( $query ){ return $query->where('email_verified_at', null); })->paginate(20);
        $dataReponse = [
            'users'  => $users,
            'title'  => $this->title_head,
        ];

        return view($this->admin_path .'.verify', $dataReponse);
    }

    public function verifyDetail($id)
    {
        $user = UserVerify::where('user_id', $id)->first();
        
        if($user){
            $dataReponse = [
                'user_verify'  => $user,
                'user'  => $user->getUser,
                'title'  => $this->title_head,
                'user_roles'  => UserRole::get(),
                'provinces'  => LocationProvince::get(),
                'url_action'  => route('admin_user.verify_post'),
            ];

            return view($this->admin_path .'.verify_edit', $dataReponse);
        } else{
            return view('404');
        }
    }

    public function verifyPost()
    {
        $data = request()->all();
        // dd($data);
        if(!empty($data['id']))
        {
            $user = User::find($data['id']);
            if($user)
            {
                $save = $data['submit']??'save';
                if($save == 'reject')
                {
                    UserVerify::where('user_id', $data['id'])->update([
                        'content'   => $data['note']??'',
                        'status'    => 2
                    ]);

                    $user->sendEmailVerifyReject($data);
                }
                else
                {
                    $user->update([
                        'email_verified_at' => \Carbon\Carbon::now(),
                        'status' => 1
                    ]);
                    $sendEmalVerify_success = $user->sendEmailVerifySuccess();
                    return redirect(sc_route('admin_user.verify'));
                }
                
            }
        }
        return redirect()->back();
    }
}