<?php
namespace App\Admin\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting, App\Models\Admin, App\Models\Addtocard, App\Models\Permission;
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

class PermissionController extends Controller
{
    public $data;
    public $template;

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
        $this->template = 'admin.permission';
        $this->data['title_head'] = 'Permissions';
    }

    public function index(){
        $this->data['permissions'] = Permission::get();
        return view($this->template .'.index', $this->data);
    }

    public function create()
    {
        return view($this->template .'.single', $this->data);
    }

    public function edit($id)
    {
        $this->data['data_admin'] = Permission::find($id);

        if($this->data['data_admin']){
            return view($this->template .'.single', $this->data);
        } else{
            return view('404');
        }
    }

    public function post(Request $rq)
    {
        $id = request('id') ?? 0;
        
        $data = request()->all();
        $dataOrigin = request()->all();

        $validator = Validator::make($dataOrigin, 
            [
                'name' => 'required|string|max:50|unique:"'.Permission::class.'",name,' . $id . '',
                'slug' => 'required|regex:/(^([0-9A-Za-z\._\-]+)$)/|unique:"'.Permission::class.'",slug,' . $id . '|string|max:50|min:3',
            ], 
            [
                'slug.regex' => __('admin.permission.slug_validate'),
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dataUpdate = [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'http_uri' => implode(',', ($data['http_uri'] ?? [])),
        ];
        
        //Edit
        if($id > 0){
            $permission = Permission::find($id);
            $permission->update($dataUpdate);
        }
        else{
            $db = Permission::create($dataUpdate);
            $id = $db->id;
        }

        $save = $data['submit'] ?? 'apply';
        if($save == 'apply'){
            $msg = "Permission has been Updated";
            $url = route('admin_permission.edit', array($id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_permission.index'));
        }
    }

    public function delete($id)
    {
        $loadDelete = Permission::find($id)->delete();

        $msg = "Permission has been Delete";
        $url = route('admin_permission.index');
        Helpers::msg_move_page($msg,$url);
    }

    public function roleGroup()
    {
        dd('');
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
 
}
