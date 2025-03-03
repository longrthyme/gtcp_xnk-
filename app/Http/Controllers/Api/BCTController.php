<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\ShopProduct;
use App\Models\PaymentRequest;
use Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;

class BCTController extends Controller
{
    public function index($year='')
    {
        // header('Access-Control-Allow-Origin: *');
        $year = $year!='' ? $year : date('Y');

        $startDate = Carbon::now()->startOfYear();
        // dd($startDate);
        $endDate = Carbon::now();
        // $analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate, $endDate));
        // $analytic = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        // dd($analytic);
        /*$analyticsData_ = Analytics::performQuery(
            Period::create($startDate, $endDate),
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:date'
            ]
            
        );*/
        // dd($analyticsData_['rows']);
        $total_visited = 0;
        /*foreach($analyticsData_['rows'] as $item)
        {
            if($item[1])
                $total_visited = $total_visited + $item[1];
        }*/

        // $soluongtruycap = app('rinvex.statistics.geoip')->count();

        $users = User::where('status', 1)->get()->count();
        $users_new = User::where('status', 1)->whereYear('created_at', $year)->get()->count();
        $posts = ShopProduct::get()->count();
        $posts_new = ShopProduct::where('status', 1)->whereYear('created_at', $year)->get()->count();

        $payments = PaymentRequest::where('status', 1)->whereYear('created_at', $year)->get()->count();
        $payments_success = PaymentRequest::where('status', 1)->whereYear('created_at', $year)->get()->count();
        $payments_error = PaymentRequest::where('status', 0)->orwhere('status', 2)->whereYear('created_at', $year)->get()->count();
        $payments_amount = PaymentRequest::where('status', 1)->selectRaw('sum(amount) as sum')->whereYear('created_at', $year)->first()->sum;

        $credit_spent = PaymentRequest::where('status', 1)->where('package_id', '<>', 0)->selectRaw('sum(amount) as sum')->whereYear('created_at', $year)->first()->sum;
        

        /*$xu_convert = setting_option('vnd-to-xu');
        $credit_spent = \App\Model\CreditSpent::selectRaw('sum(spent) as sum')->whereYear('created_at', $year)->first()->sum;
        if($credit_spent){
            $credit_spent = $credit_spent * $xu_convert;
        }*/
        // "TongSoDonHangThanhCong" => $payments_success,
        // "TongSoDonHangKhongThanhCong" => $payments_error,
        $data = [
            "soLuongTruyCap" => sc_totalVisits() ?? 0,
            "soNguoiBan" => $users,
            "soNguoiBanMoi" => $users_new,
            "tongSoSanPham" => $posts,
            "soSanPhamMoi" => $posts_new,
            "soLuongGiaoDich" => 0,
            "tongSoDonHangThanhCong" => 0,
            "tongSoDonHangKhongThanhCong" => 0,
            "tongGiaTriGiaoDich" => 0,
        ];
        return response()->json($data);
    }

    public function loginBaocao()
    {
        $user = 'BaocaoTMDT';
        $password = 'sqfF3fRs';
        $data = request()->all();
        // dd(session());
        if($user == $data['username'] && $password == $data['password'])
        {
            session()->put('baocao_auth', 1);
            // dd(session('baocao_auth'));
        }
        return redirect(route('api.bct_baocao'));
    }
    public function logout()
    {
        session()->forget('baocao_auth');
        return redirect(route('api.bct_baocao'));
    }
    public function baocao()
    {
        $data = $this->index();
        $data = $data->getData();
        // dd(session('baocao_auth'));
        return view('api.baocao', [
            'data' => $data,
            'seo' => [
                'seo_title' => setting_option('company_name') .' Analytics'
            ],
        ]);
    }
}
