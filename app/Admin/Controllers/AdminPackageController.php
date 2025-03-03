<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Cache;

use App\Models\Package;
use App\Models\PackageOption;
use App\Models\PackageDay;
use App\Models\PackageDayJoin;

class AdminPackageController extends Controller
{
    public $template = 'admin.package';
    public $data;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->data['title'] = __('Gói tin đăng');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $this->data['packages'] = Package::orderBy('sort')->orderByDesc('id')->paginate(20);
        return view($this->template .'.index', $this->data);
    }

    public function create(){
        return view($this->template .'.single', $this->data);
    }

    public function edit($id){

        $package = Package::findorfail($id);

        $this->data['package'] = $package;
        $this->data['price_day'] = $package->packageDays;
        $this->data['packagedays'] = (new PackageDay)->get();
        $this->data['options'] = (new PackageOption)->getAllActive();
        $this->data['package_options'] = $package->getOptions();
        if($this->data['package']){
            return view($this->template .'.single', $this->data);
        } else{
            return view('404');
        }
    }

    public function post(Request $rq){
        $data = request()->except(['_token', 'updated_at', 'submit', 'option', 'package_price']);
        $id = $rq->id;

        $data['price'] = str_replace(',', '', $data['price']);
        $data['promotion'] = $data['promotion']??0;
        $save = $rq->submit ?? 'apply';

        $package = Package::updateOrCreate(
            ['id' => $id],
            $data
        );

        $options = request('option');
        $package->options()->delete();
        if(is_array($options) && count($options))
        {
            foreach($options as $item)
            {
                \App\Models\PackageOptionJoin::create([
                    'package_id'    => $package->id,
                    'option_id'    => $item,
                ]);
            }
        }

        $package->packageDays()->delete();
        if(!empty($rq['package_price']))
        {
            foreach($rq['package_price'] as $day_id => $item)
            {
                PackageDayJoin::create([
                    'package_id'    => $package->id,
                    'day_id'    => $day_id,
                    'price' => $item['price']??0,
                    'price' => $item['price']??0,
                    'promotion' => $item['promotion']??0,
                ]);
            }
        }

        if($save=='apply'){
            $msg = "Package has been Updated";
            $url = route('admin.package.edit', array($package->id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.package'));
        }
    }

    public function showHome()
    {
        $id = request('id');
        if($id){
            $package = Package::find($id);
            $show_home = $package->show_home == 0 ? 1 : 0;
            Package::updateOrCreate(
                ['id' => $id],
                [
                    'show_home' => $show_home
                ]
            );
            return response()->json([
                'error' => 0,
                'msg'   => 'Cập nhật thành công'
            ]);
        }
    }
    public function priority()
    {
        $id = request('id');
        $priority = request('priority');
        if($id){
            $package = Package::find($id);
            if($priority >= 0){
                Package::updateOrCreate(
                    ['id' => $id],
                    [
                        'sort' => $priority
                    ]
                );
                return response()->json([
                    'error' => 0,
                    'msg'   => 'Cập nhật thành công'
                ]);
            }
            return response()->json([
                'error' => 0,
                'msg'   => 'Cập nhật không thành công, số phải là số dương'
            ]);
        }
    }
}
