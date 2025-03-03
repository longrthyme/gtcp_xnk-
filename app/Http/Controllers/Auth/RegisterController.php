<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;

use App\Models\UserRole;
use App\Models\UserType;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function index()
    {
        if(!empty(request('code')))
            session()->put('invite_code', request('code'));

        if (!Auth::check()) 
        {
            $account_type = request('type') != 'user'?1:0;
            // dd($account_type);

            $user_roles = (new UserRole)->where('status', 1)->where('account_type', '<=', $account_type)->get();
            $dataReponse = [
                'user_types'    => (new UserType)->getListActive(),
                'user_roles'    => $user_roles,
                'seo_title' => 'Đăng ký',
                'index' => 'noindex, nofollow'
            ];
            return view('auth.register', $dataReponse);
        }
        // return redirect(url('/'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validation_rules = array(
            'fullname' => 'required|max:255',
            'birthday' => 'required',
            'cccd' => 'required',
            'cccd_date' => 'required',
            'cccd_place' => 'required',
            'phone' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:255|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        );
        $messages = array(
            'fullname.required' => 'Vui lòng nhập họ tên',
            'birthday.required' => 'Vui lòng nhập Ngày sinh',
            'cccd.required' => 'Vui lòng nhập CCCD',
            'cccd_date.required' => 'Vui lòng nhập Ngày cấp',
            'cccd_place.required' => 'Vui lòng nhập nơi cấp',
            'email.required' => 'Vui lòng nhập địa chỉ Email',
            'email.email' => 'Địa chỉ Email không đúng định dạng',
            'email.max' => 'Địa chỉ Email tối đa 255 ký tự',
            'email.unique' => 'Địa chỉ Email đã tồn tại',
            'username.required' => 'Vui lòng nhập Tên đăng nhập',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password_confirmation.same' => 'Mật khẩu và nhập lại mật khẩu chưa trùng khớp!',
        );

        return Validator::make($data,  $validation_rules, $messages);
    }

    protected function validatorCompany(array $data)
    {
        $validation_rules = array(
            'fullname' => 'required|max:255',
            'other_name' => 'required',
            'company' => 'required',
            'address' => 'required',
            'mst' => 'required',
            'job' => 'required',
            'phone' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:255|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        );
        $messages = array(
            'fullname.required' => 'Vui lòng nhập họ tên',
            'other_name.required' => 'Vui lòng nhập tên Người đại diện pháp luật',
            'company.required' => 'Hãy nhập Tên Công ty',
            'address.required' => 'Hãy nhập Địa chỉ Công ty',
            'mst.required' => 'Hãy nhập Mã số thuế',
            'job.required' => 'Vui lòng nhập Chức vụ',
            'email.required' => 'Vui lòng nhập địa chỉ Email',
            'email.email' => 'Địa chỉ Email không đúng định dạng',
            'email.max' => 'Địa chỉ Email tối đa 255 ký tự',
            'email.unique' => 'Địa chỉ Email đã tồn tại',
            'username.required' => 'Vui lòng nhập Tên đăng nhập',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'password.required' => 'Hãy nhập mật khẩu',
            'password_confirmation.same' => 'Mật khẩu và nhập lại mật khẩu chưa trùng khớp!',
        );

        return Validator::make($data,  $validation_rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(!empty($data['birthday']))
            $birthday = date('Y-m-d', strtotime($data['birthday']));
        if(!empty($data['cccd_date']))
            $cccd_date = date('Y-m-d', strtotime($data['cccd_date']));
        return User::create([
            'account_type' => !empty($data['account_type']) && $data['account_type'] == 'company' ? 1 : 0,
            'username' => $data['username'],
            'fullname' => $data['fullname'],
            'other_name' => $data['other_name']??'',
            'birthday' => $birthday??null,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'full_phone' => $data['full_phone']??'',
            'cccd' => $data['cccd']??'',
            'cccd_date' => $cccd_date??'',
            'cccd_place' => $data['cccd_place']??'',
            'role' => $data['role']??0,
            'type' => $data['type']??0,
            'job' => $data['job']??'',
            'company' => $data['company']??'',
            'address' => $data['address']??'',
            'mst' => $data['mst']??'',
            'website' => $data['website']??'',
            'invited_code' => session('invite_code')??'',
            'status' => 2,
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = $request->all();
        if($data['account_type'] == 'company')
            $this->validatorCompany($data)->validate();
        else
            $this->validator($data)->validate();

        if(!empty($data['type']) && $data['type'] == 3)
        {
            $data['role'] = 0;
        }

        event(new Registered($user = $this->create($data)));

        //Send email verify
        $user->sendEmailVerify();

        // $this->guard()->login($user);

        // $this->registered($request, $user);
        return redirect(route('register_success'));
        /*return response()->json([
            'error' => 0,
            'view' => view('auth.register_success')->render(),
            'msg'   => __('Register success')
        ]);*/
    }

}
