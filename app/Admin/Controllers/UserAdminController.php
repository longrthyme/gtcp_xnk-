<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting, App\Models\Admin, App\Models\Addtocard;
use App\Models\Theme, App\Models\Category_Theme, App\Models\Join_Category_Theme;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use App\User;
use Auth, DB, File, Image, Redirect, Cache;
use App\Exports\CustomerExport;
use App\Exports\OrderExport;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Validator;

use App\Models\AdminRole;

class UserAdminController extends Controller
{
    public $data, $roles;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $routes = app()->routes->getRoutes();
        foreach ($routes as $route) {
            if (Str::startsWith($route->uri(), SC_ADMIN_PREFIX)) {
                $prefix = SC_ADMIN_PREFIX ? $route->getPrefix() : ltrim($route->getPrefix(),'/');
                $routeAdmin[$prefix] = [
                    'uri'    => 'ANY::' . $prefix . '/*',
                    'name'   => $prefix . '/*',
                    'method' => 'ANY',
                ];
                foreach ($route->methods as $key => $method) {
                    if ($method != 'HEAD' && !collect($this->without())->first(function ($exp) use ($route) {
                        return Str::startsWith($route->uri, $exp);
                    })) {
                        $routeAdmin[] = [
                            'uri'    => $method . '::' . $route->uri,
                            'name'   => $route->uri,
                            'method' => $method,
                        ];
                    }

                }
            }

        }

        $this->data['routeAdmin'] = $routeAdmin;
        $this->roles       = AdminRole::pluck('name', 'id')->all();
    }

    public function index(){
        $this->data['data_user'] = Admin::get();
        return view('admin.user-admin.index', $this->data);
    }

    public function create()
    {
        $this->data =[
            'roles'             => $this->roles,
        ];
        return view('admin.user-admin.single', $this->data);
    }

    public function edit($id)
    {
        $user = Admin::find($id);
        $this->data =[
            'data_admin'        => $user,
            'roles'             => $this->roles,
            'user_roles'        => $user->roles->pluck('id')->toArray(),
        ];
        if($user){
            return view('admin.user-admin.single', $this->data);
        } else{
            return view('404');
        }
    }

    public function post(Request $rq)
    {
        $sid = $rq->sid ?? 0;
        $data = $rq->all();

        $change_pass = $data['check_pass'] ?? 0;
        if($change_pass || $sid == 0){
            $this->validate($rq,[
                'email' => 'required|unique:"'.Admin::class.'",email,' . $sid . '',
                'password'      => 'required|confirmed',
                'name'          => 'required',
            ],[
                'email.required' => 'Hãy nhập vào địa chỉ Email',
                'email.email' => 'Địa chỉ Email không đúng định dạng',
                'email.unique' => 'Địa chỉ Email đã tồn tại',
                'password.required' => 'Hãy nhập mật khẩu',
                'password.confirmed' => 'Xác nhận mật khẩu không đúng',
                'name.required' => 'Tên không được trống',
            ]);
        }else{
            $this->validate($rq,[
                'email' => 'required|string|max:50|unique:"'.Admin::class.'",email,' . $sid . '',
                'name'          => 'required',
            ],[
                'email.required' => 'Hãy nhập vào địa chỉ Email',
                'email.email' => 'Địa chỉ Email không đúng định dạng',
                'email.unique' => 'Địa chỉ Email đã tồn tại',
                'name.required' => 'Tên không được trống',
            ]);
        }

        /*if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()->back()->withErrors($error);
        }
*/
        $dataUpdate = [
            'email'     => $rq->email,
            'name'      => $rq->name,
            
            'admin_level' => $rq->admin_level,
            'email_info'     => $rq->email,
            'status'    => $rq->status,
            'admin_level'    => 1
        ];
        if($rq->password)
            $dataUpdate['password']  = bcrypt($rq->password);

        if($sid == 0){
            $user = Admin::create($dataUpdate);

            $roles = $data['roles'] ?? [];
            $permission = $data['permission'] ?? [];

            //Process role special
            if(in_array(1, $roles)) {
                // If group admin
                $roles = [1];
                $permission = [];
            } else if(in_array(2, $roles)) {
                // If group onlyview
                $roles = [2];
                $permission = [];
            }
            //End process role special

            //Insert roles
            if ($roles) {
                $user->roles()->attach($roles);
            }
            //Insert permission
            if ($permission) {
                $user->permissions()->attach($permission);
            }
        }
        else{
            $user = Admin::find($sid);
            $user->update($dataUpdate);
            // dd($user);
            if(!in_array($user->id, SC_GUARD_ADMIN)) {
                $roles = $data['roles'] ?? [];
                $permission = $data['permission'] ?? []; 
                $user->roles()->detach();
                // $user->permissions()->detach();
                //Insert roles
                if ($roles) {
                    $user->roles()->attach($roles);
                }
                //Insert permission
                if ($permission) {
                    $user->permissions()->attach($permission);
                }

            }
        }

        $save = $data['submit'] ?? 'apply';
        if($save == 'apply'){
            $msg = "User admin has been Updated";
            $url = route('admin.userAdminDetail', array($user->id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_permission.index'));
        }
    }

    public function deleteUserAdmin($id)
    {
        $loadDelete = Admin::find($id)->delete();
        $msg = "Admin account has been Delete";
        $url = route('admin.listUserAdmin');
        Helpers::msg_move_page($msg,$url);
    }


    public function without()
    {
        $prefix = SC_ADMIN_PREFIX?SC_ADMIN_PREFIX.'/':'';
        return [
            $prefix . 'login',
            $prefix . 'logout',
            $prefix . 'forgot',
            $prefix . 'deny',
            $prefix . 'locale',
            $prefix . 'uploads',
        ];
    }

    public function changePassword(){
        return view('admin.change-password');
    }

    public function postChangePassword(Request $rq){
        $user = Auth::guard('admin')->user();
        $id = $user->id;
        $current_pass = $user->password;
        if($rq->check_pass_value=='off'){
            //no change pass
           $data = array(
                    'email' => $rq->email,
                    'name' => $rq->name,
                    'phone' => $rq->phone,
                    'address' => $rq->address,
                    'email_info' => $rq->email,
                ); 
        }
        else{
            //change pass
        if(Hash::check($rq->current_password, $user->password)){
            if($rq->new_password == $rq->confirm_password){
                $data = array(
                    'email' => $rq->email,
                    'name' => $rq->name,
                    'password' => bcrypt($rq->new_password),
                    'phone' => $rq->phone,
                    'address' => $rq->address,
                    'email_info' => $rq->email,
                );
            } else{
                $msg = 'Mật khẩu xác nhận không trùng khớp';
                return Redirect::back()->withErrors($msg);
            }
        } else{
            $msg = 'Mật khẩu hiện tại không chính xác';
            return Redirect::back()->withErrors($msg);
        }
        }
        $respons =DB::table('admins')->where("id","=",$id)->update($data);
        $msg = "Thông tin cập nhật thành công!";
        $url=  route('admin_user_admin.change_password');
        Helpers::msg_move_page($msg,$url);
    }
    
 
}
