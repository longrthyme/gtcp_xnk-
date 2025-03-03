<?php
namespace App\Admin\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\AdminPermission;
use App\Models\AdminRole;
use App\Models\AdminUser;
use Validator;
use App\Libraries\Helpers;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public $template;
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->template = 'admin.role';
        $this->data['title_head'] = 'Nhóm quyền';
    }
    
    public function index()
    {
        $this->data['roles'] = AdminRole::get();
        return view($this->template.'.index', $this->data);
    }

/**
 * Form create new item in admin
 * @return [type] [description]
 */
    public function create()
    {
        $this->data['permission'] = \App\Models\Permission::pluck('name', 'id')->all();
        // dd($this->data['permission_selected']);
        return view($this->template .'.single', $this->data);
        
    }

/**
 * Post create new item in admin
 * @return [type] [description]
 */
    public function postCreate()
    {
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required|string|max:50|unique:"'.AdminRole::class.'",name',
            'slug' => 'required|regex:/(^([0-9A-Za-z\._\-]+)$)/|unique:"'.AdminRole::class.'",slug|string|max:50|min:3',
        ], [
            'slug.regex' => sc_language_render('admin.role.slug_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataInsert = [
            'name' => $data['name'],
            'slug' => $data['slug'],
        ];

        $role = AdminRole::createRole($dataInsert);
        $permission = $data['permission'] ?? [];
        $administrators = $data['administrators'] ?? [];
        //Insert permission
        if ($permission) {
            $role->permissions()->attach($permission);
        }
        //Insert administrators
        if ($administrators) {
            $role->administrators()->attach($administrators);
        }
        return redirect()->route('admin_role.index')->with('success', sc_language_render('action.create_success'));

    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $this->data['data_role'] = AdminRole::find($id);
        
        if($this->data['data_role']){
            $this->data['permission_selected'] = $this->data['data_role']->permissions()->pluck('id')->toArray();
            $this->data['permission'] = \App\Models\Permission::pluck('name', 'id')->all();
            // dd($this->data['permission_selected']);
            return view($this->template .'.single', $this->data);
        } else{
            return view('404');
        }
    }

/**
 * update status
 */
    public function post()
    {
        $id = request('id') ?? 0;

        
        $data = request()->all();
        $dataOrigin = request()->all();
        $validator = Validator::make($dataOrigin, [
            'name' => 'required|string|max:50|unique:"'.AdminRole::class.'",name,' . $id . '',
            'slug' => 'required|regex:/(^([0-9A-Za-z\._\-]+)$)/|unique:"'.AdminRole::class.'",slug,' . $id . '|string|max:50|min:3',
        ], [
            'slug.regex' => __('admin.role.slug_validate'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
//Edit

        $dataUpdate = [
            'name' => $data['name'],
            'slug' => $data['slug'],
        ];

        //Edit
        if($id > 0){
            $role = AdminRole::find($id);
            $role->update($dataUpdate);


            $permission = $data['permission'] ?? [];
            $administrators = $data['administrators'] ?? [];
            $role->permissions()->detach();
            // $role->administrators()->detach();
            //Insert permission
            if ($permission) {
                $role->permissions()->attach($permission);
            }
            //Insert administrators
            if ($administrators) {
                $role->administrators()->attach($administrators);
            }
    //
        }
        else{
            $db = AdminRole::create($dataUpdate);
            $id = $db->id;
        }

        $save = $data['submit'] ?? 'apply';
        if($save == 'apply'){
            $msg = "Permission has been Updated";
            $url = route('admin_role.edit', array($id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_role.index'));
        }

        
        return redirect()->route('admin_role.index')->with('success', sc_language_render('action.edit_success'));

    }

/*
Delete list Item
Need mothod destroy to boot deleting in model
 */
    public function delete($id)
    {
        $loadDelete = AdminRole::find($id)->delete();

        $msg = "Role has been Delete";
        $url = route('admin_role.index');
        Helpers::msg_move_page($msg,$url);
    }

}
