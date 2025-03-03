<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        if (!Auth::check()) {
            $this->data['seo'] = [
                'seo_title' => 'Đăng nhập',
                'index' => 'noindex, nofollow'
            ];
            session(['link' => url()->previous()]);
            return view('auth.login', $this->data);
        }
        return redirect(url('/'));
    }

    public function post(Request $request)
    {
        $data_return = ['status'=>"success", 'message'=>'Thành công'];

        $login = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        if($request->remember_me == 1){
            $remember_me = true;
        } else{
            $remember_me = false;
        }

        $check_user = User::where('username', $request->username)->first();
        
        if($check_user!='')
        {
            $sessions = $check_user->sessions;
            if($sessions->count() && !$sessions->first()->isExpired())
            {
                return response()->json(
                    [
                        'error' => 1,
                        'expires_at' => $sessions->first()->expires_at,
                        'msg'   => __('Tài khoản đang đăng nhập trên thiết bị khác!')
                    ]
                );
            }
            $check_user->sessions()->delete();
            
            if($check_user->status==1 || ($check_user->status == 2))
            {
                if (Auth::attempt($login, $remember_me)) {
                    return response()->json(
                        [
                            'error' => 0,
                            'redirect_back' => $request->url_back??'/', //redirect()->back(),
                            'view' => view('auth.login_success', ['redirect_back' => $request->url_back??''])->render(),
                            'msg'   => __('Login success')
                        ]
                    );
                } 
                else {
                    return response()->json(
                        [
                            'error' => 1,
                            'msg'   => __('Username or Password is wrong')
                        ]
                    );
                }
            } 
            else {
                return response()->json(
                    [
                        'error' => 1,
                        'msg'   => __('Tài khoản không hoạt động!')
                    ]
                );
            }
        }
        else {
            return response()->json(
                [
                    'error' => 1,
                    'msg'   => __('Account does not exist!')
                ]
            );
        }
    }
}
