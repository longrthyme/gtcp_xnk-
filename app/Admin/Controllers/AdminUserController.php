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

class AdminUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
  
  
    
    public function listUsers(){
        $data_user = User::get();
        return view('admin.users.index')->with(['data_user' => $data_user]);
    }

    public function listUserAdmin(){
        $data_user = Admin::get();
        return view('admin.user-admin.index')->with(['data_user' => $data_user]);
    }

    public function addUserAdmin()
    {
        return view('admin.user-admin.single');
    }

    public function userAdminDetail($id)
    {
        $data_admin = Admin::where('id', '=', $id)->first();
        if($data_admin){
            return view('admin.user-admin.single')->with(['data_admin' => $data_admin]);
        } else{
            return view('404');
        }
    }

    public function postAddUserAdmin(Request $rq)
    {
        $this->validate(
            $rq,
            [
                'email'         => 'required',
                'password'      => 'required',
                'repassword'    => 'required|same:password',
                'name'          => 'required',
                'admin_level'   => 'required',
            ]
        );
        $sid = $rq->sid;
        $data = $rq->all();
        if($sid==0)
        {
            //insert
            $data = [
                'email'     => $rq->email,
                'name'      => $rq->name,
                'password'  => bcrypt($rq->password),
                'admin_level' => $rq->admin_level,
                'email_info'     => $rq->email,
                'status'    => $rq->status
            ];
           $respons = Admin::create($data);
           $id_insert= $respons->id;
           if($id_insert>0):
            $msg = "Admin account has been registered";
            $url = route('admin.userAdminDetail', array($id_insert));
            Helpers::msg_move_page($msg,$url);
        endif;
        }
        else{
            //update
         if($rq->password!=""){
            //update pass
            $data = [
                'email'     => $rq->email,
                'name'      => $rq->name,
                'password'  => bcrypt($rq->password),
                'admin_level' => $rq->admin_level,
                'email_info'     => $rq->email,
                'status'    => $rq->status
            ];
        }
        else{
            //no update pass
            $data = [
                'email'         => $rq->email,
                'name'          => $rq->name,
                'admin_level'   => $rq->admin_level,
                'email_info'     => $rq->email,
                'status'        => $rq->status
            ];
        }
        
        $respons = Admin::where ("id", "=", $sid)->update($data);
        $msg = "Admin account has been Updated";
        $url = route('admin.userAdminDetail', array($sid));
        Helpers::msg_move_page($msg,$url);
        }
    }

    public function deleteUserAdmin($id)
    {
        $loadDelete = Admin::find($id)->delete();

        //delete products
        $productDelete = Theme::all();
        if($loadDelete){
          foreach($productDelete as $value){
            if($value->admin_id==$id){
                    $value->delete();
                }
            }     
        }
        
        $msg = "Admin account has been Delete";
        $url = route('admin.listUserAdmin');
        Helpers::msg_move_page($msg,$url);
    }
 
}
