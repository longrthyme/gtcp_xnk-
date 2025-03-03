<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Cart, Auth;

use Illuminate\Support\Facades\Http;
use App\Models\LocationProvince;
use App\Models\LocationDistrict;
use App\Models\LocationWard;

class LocationController extends Controller
{
	public $ghn_districts=[];
	protected $service;

	public function __construct()
    	{
        parent::__construct();
        $this->ghn_districts = [];
   	}
	public function getDistrict()
	{
		$province_name = request()->id??'';
		$name = request()->name??'';
		if($province_name)
		{
			$html = '';
			$province = LocationProvince::where('name', $province_name)->first();
			$districts = LocationDistrict::where('province_id', $province->id)->get();

			$html .= '<option value=""> --- Chọn Quận/Huyện --- </option>';
	        	foreach ($districts as $item) {
	            $select = '';
	            if(in_array($name, [$item->type_name, $item->name]))
	                 $select = 'selected';
	            $html .= '<option value="'.$item->name.'" ' .$select. '>'.$item->type_name.'</option>';
	        	}
	        	return [
	        		'view' => $html
	        	];
		}
		return;
	}
	public function getWard()
	{
		$district_name = request()->id??'';
		$name = request()->name??'';
		if($district_name)
		{
			$district = LocationDistrict::where('name', $district_name)->first();
			$wards = LocationWard::where('district_id', $district->id)->get();
			$html = '<option value=""> --- Chọn Phường/xã --- </option>';
	        	foreach ($wards as $item) {
	            $select = '';
	            if(in_array($name, [$item->type_name, $item->name]))
	                 $select = 'selected';
	            $html .= '<option value="'.$item->name.'" ' .$select. '>'.$item->type_name.'</option>';
	        	}
	        	return [
	        		'view' => $html
	        	];
		}
		return;
	}

	public function placeSelect()
	{
		$data = request()->all();
		$province_name = $data['province_id']??0;
		if($province_name)
		{
			$province = LocationProvince::where('name', $province_name)->first();

			$districts = LocationDistrict::where('province_id', $province->id)->get();

			$district = LocationDistrict::where('name', $data['district_id']??'')->where('province_id', $province->id)->first();

			if($district)
			{
				$ward = LocationWard::where('name', $data['ward_id']??'')->where('district_id', $district->id)->first();
				$wards = LocationWard::where('district_id', $district->id)->get();
			}

			$address = array_filter([$ward->name??'', $district->name??'', $province->name??'']);
			$address = implode(', ', $address);

			$dataReponse = array_merge($data, [
				'provinces' => LocationProvince::get(),
				'districts'	=> $districts??'',
				'wards'	=> $wards??'',
			]);
			$view = view($this->templatePath .'.dangtin.form.block_location', $dataReponse)->render();
			return response()->json([
				'error'	=> 0,
				'html'	=> $view,
				'address'	=> $address??'',
				'message'	=> 'Success'
			]);
		}

		return response()->json([
			'error'	=> 1,
			'html'	=> '',
			'message'	=> 'Error'
		]);
	}

	public function searchPlace()
	{
		$keyword = request('keyword')??'';
		if($keyword != '')
		{
			$response = Http::withoutVerifying()->withHeaders([
              'Content-Type' =>  'application/json',
         ])->get('https://user.phaata.com/user/searchports/seaport', ['search' => $keyword]);
         $datas = $response->json();
         return response()->json($datas);
		}
	}
}
?>