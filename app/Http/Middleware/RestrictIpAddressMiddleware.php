<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class RestrictIpAddressMiddleware
{
    // Blocked IP addresses
    public $restrictedIpSanbox = ['113.160.92.202'];
    public $restrictedIp = ['113.52.45.78', '116.97.245.130', '42.118.107.252', '113.20.97.250', '203.171.19.146', '103.220.87.4', '103.220.86.4'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {;
        if (!in_array($request->ip(), $this->restrictedIpSanbox)) {
            return response()->json(['message' => "You are not allowed to access this site."]);
        }
        return $next($request);
    }     
}