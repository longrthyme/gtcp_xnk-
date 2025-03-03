<?php 
use Illuminate\Support\Facades\Log;
use App\Models\StatisticalLog;
use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

if (!function_exists('sc_statistical_log')) {
    function sc_statistical_log()
    {
        $user = auth()->user();
        $user_id = $user->id??0;
        $ip = request()->ip();
        $url_current = url()->current();

        $time = Carbon::now()->subMinute(5)->format('Y-m-d H:i');
        $log = StatisticalLog::where('user_id', $user_id)
            ->where('ip', $ip)
            ->where('url', $url_current)
            ->where('created_at', '>', $time)
            ->first();
        
        if(!$log)
        {
            $route_name = Route::current() ? Route::current()->getName() : '';
            // $route_name_ = \Request::route()->getName();

            Log::info(Route::currentRouteName());
            /*if(in_array($route_name, ['index', 'news', 'post.single', 'product', 'product.baogia']))
            {*/
                /*(new StatisticalLog)->create_record([
                    'user_id'   => $user_id,
                    'route'   => $route_name,
                    'ip'   => $ip,
                    'url'   => $url_current,
                    'device'    => request()->userAgent(),
                ]);*/
        }

        sc_statistical_info();


        return ;
    }
}

function sc_statistical_info()
{
    $now = Carbon::now();
    $start = $now->copy()->startOfDay();
    $three_days_before = $start->subDay()->format('Y-m-d H:i');
    $total_visits = StatisticalLog::where('created_at', '<=', $three_days_before);
    $count = $total_visits->count();
    
    if($count)
    {
        $total = $count + (int)setting_option('total-visits');
        Log::info('Update visits: '. $total);

        $setting = Setting::updateOrCreate(
            [
                'name' => 'total-visits'
            ],
            [
                'content'   => $total,
                'created_at'    => $now->format('Y-m-d H:i')
            ]
        );

        $total_visits->delete();
        Cache::forget('theme_option');
    }
    return;
}

function sc_onlineUsers()
{
    return (new StatisticalLog)->onlineUsers();
}

function sc_totalVisits()
{
    $total = (int)setting_option('total-visits');
    $total_log = (new StatisticalLog)->totalVisits();
    // Log::debug($total);
    return $total+$total_log;

}