<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Customer;
use Auth;
use Validator;
use Redirect;
use Route;
use Hash;
use Mail;
use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\Category;
use App\Models\Rating_Product;
use App\Models\Wishlist;
use App\Models\Addtocard;
use App\Models\Shipping_order;
use App\Models\Customer_forget_pass_otp;
use DB, Input, File, Str;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Libraries\Helpers;

use App\Models\ShopOrderStatus;
use App\Models\ShopOrderPaymentStatus;
use App\Models\Page;

class CustomerController extends Controller
{

    use \App\Traits\LocalizeController;
    
    public $currency, $ghn_service;
    public $data = [
        'error' => false,
        'success' => false,
        'message' => ''
    ];

    public function __construct()
    {
        parent::__construct();
        $this->data['statusOrder']    = ShopOrderStatus::getIdAll();
        $this->data['orderPayment']    = ShopOrderPaymentStatus::getIdAll();
    }

    public function showphone()
    {
        $id = request('id')??'';
        if($id && auth()->check())
        {
            $user = User::find($id);
            return $user->getPhone();
        }
    }

    public function index()
    {
       return view($this->templatePath .'.customer.home');
    }

    public function showLoginForm()
    {
        if (!Auth::check()) {
            $this->localized();
            $this->data['seo'] = [
                'seo_title' => 'Đăng nhập',
            ];
            return view($this->templatePath.'.customer.login', $this->data);
        }
        return redirect(url('/'));
    }

    public function postLogin(Request $request)
    {
        $data_return = ['status'=>"success", 'message'=>'Thành công'];

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if($request->remember_me == 1){
            $remember_me = true;
        } else{
            $remember_me = false;
        }

        $check_user = User::where('email', $request->email)->first();
        if($check_user!=''){
            if (Auth::attempt($login, $remember_me)) {
                session()->forget('shippingAddress');
                return response()->json(
                    [
                        'error' => 0,
                        'redirect_back' => $request->url_back??'/', //redirect()->back(),
                        'view' => view($this->templatePath .'.customer.includes.login_success')->render(),
                        'msg'   => __('Login success')
                    ]
                );
            } 
            else {
                return response()->json(
                    [
                        'error' => 1,
                        'msg'   => __('Email or Password is wrong')
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

    public function registerSuccess()
    {
        // return view($this->templatePath .'.customer.includes.register_success');
        return view('auth.register_success',[
            'seo_title' => 'Register success'
        ]);
    }

    public function profile(){
        $user = auth()->user();

        $sessions = $user->sessions;
        // dd($sessions->first()->expires_at);
        // echo $sessions->expires_at;
        $this->data['user'] = $user;
        $this->data['options'] = $user->getOptions();
        $this->data['provinces'] = \App\Models\LocationProvince::get();
        $this->data['user_company'] = $user->getCompany;
        $this->data['seo'] = [
            'seo_title' => 'Thông tin',
        ];
        return view($this->templatePath .'.customer.profile', $this->data);
    }
    public function updateProfile(Request $rq){
        $id = Auth::user()->id;
        $name_field = "avatar_upload";
        if($rq->avatar_upload){
            $image_folder="/images/avatar/";

            $file = $rq->file($name_field);
            $file_name = uniqid() . '-' . $file->getClientOriginalName();
            $name_avatar = $image_folder . $file_name;

            
            $file->move( public_path().$image_folder, $file_name );
            if(Auth::user()->avatar !='' && file_exists( public_path().Auth::user()->avatar )){
                if(file_exists(asset(public_path().Auth::user()->avatar)))
                    unlink( asset(public_path().Auth::user()->avatar) );
            }
        }
        else
            $name_avatar = Auth::user()->avatar;

        if(!empty($rq->cccd_date))
            $cccd_date = date('Y-m-d', strtotime($rq->cccd_date));
        $data= array(
            'fullname' => $rq->fullname??'',
            'firstname' => $rq->firstname??'',
            'lastname' => $rq->lastname??'',
            'address' => $rq->address??'',
            'birthday' => $rq->birthday ?? null,
            'company' => $rq->company ?? '',
            'company_date' => $rq->company_date ?? '',
            'mst' => $rq->mst ?? '',
            'country' => $rq->country ?? '',
            'province' => $rq->province ?? '',
            'district' => $rq->district ?? '',
            'ward' => $rq->ward ?? '',
            'postal_code' => $rq->postal_code ?? 0,
            'avatar' => $name_avatar,
            'phone' => $rq->phone,
            'coin_address' => $rq->coin_address??'',
            'bank_info' => $rq->bank_info??'',
            'about_me' => $rq->about_me??'',
            'website'       => $rq->website??'',
            'cccd'          => $rq->cccd??'',
            'cccd_date'     => $cccd_date??'',
            'cccd_place'    => $rq->cccd_place??'',
            'bank_account'  => $rq->bank_account??'',
            'bank_number'   => $rq->bank_number??'',
            'bank_name'     => $rq->bank_name??'',
            'bank_branch'   => $rq->bank_branch??'',
        );
        $user =(new User)->find($id);
        $user->update($data);

        if(!empty($rq->option) && count($rq->option))
        {
            // dd($rq->option);
            $user->getOptions()->delete();
            $user->createOption($rq->option);
        }

        $msg = "Thông tin tài khoản đã được cập nhật";
        $url=  route('customer.profile');
        Helpers::msg_move_page($msg,$url);
    }

    function editAvatar()
    {
        $user = auth()->user();

        $image = request('image');
        $image_array_1 = explode(";", $image);
        $image_array_2 = explode(",", $image_array_1[1]);
        $image_folder = "/images/avatar/";

        $image = base64_decode($image_array_2[1]);

        $image_name = uniqid() . '-' . $user->id. '.jpg';
        $name_avatar = $image_folder . $image_name;

        file_put_contents(public_path().$name_avatar, $image);
        User::find($user->id)->update(['avatar' => $name_avatar]);
        return response()->json([
            'error' => 0,
            'avatar'    => $name_avatar,
        ]);
    }

    function updateCompany()
    {
        $data = request('company');
        // dd($data);
        if($data)
        {
            $user = auth()->user();
            // dd($user)
            $user->getCompany()->delete();
            \App\Models\UserCompany::create([
                'user_id'   => $user->id,
                'name'   => $data['name']??'',
                'mst'   => $data['mst']??'',
                'phone'   => $data['phone']??'',
                'email'   => $data['email']??'',
                'address'   => $data['address']??'',
            ]);
            $msg = "Thông tin công ty đã được cập nhật";
            $url=  route('customer.profile');
            Helpers::msg_move_page($msg,$url);
        }
    }

    public function myPost()
    {
        $user = auth()->user();
        // $products = \App\Models\ShopProduct::where('user_id', $user->id)->orderbyDesc('id')->paginate(10);
        $products = (new \App\Models\ShopProduct)->getList([
            'user_id' => $user->id,
            'get_all'   => true
        ]);

        $dataReponse = [
            'products' => $products,
            'seo_title' => 'Quản lý tin đăng'
        ];
        
        return view($this->templatePath .'.customer.manager_post', $dataReponse);
    }

    public function deletePost($id)
    {
        // dd($id);
        $db = ShopProduct::where('id', $id)->where('user_id', auth()->user()->id)->first();
        if($db)
        {  
            $db->delete();
            return redirect()->back()->with(['message' => 'Xóa tin '. $db->sku .' thành công']);
        }
    }

    public function logoutCustomer(){
        Auth::logout();
        return redirect()->route('index');
    }
    public function changePassword(){
        $this->data['user'] = Auth::user();
        return view('auth.passwords.change_pass')->with(['data'=>$this->data]);
    }
    public function postChangePassword(Request $rq){
        $user = Auth::user();
        $id = $user->id;
        $current_pass = $user->password;
        if(Hash::check($rq->current_password, $user->password)){
            if($rq->new_password != '' && $rq->new_password == $rq->confirm_password){
                $data = array(
                    'password' => bcrypt($rq->new_password)
                );
            } else{
                $msg = 'Mật khẩu xác nhận không trùng khớp';
                return Redirect::back()->withErrors($msg);
            }
        } else{
            $msg = 'Mật khẩu hiện tại không chính xác';
            return Redirect::back()->withErrors($msg);
        }
        $respons =DB::table('users')->where("id","=",$id)->update($data);
        $msg = "Mật khẩu đã được thay đổi";
        $url=  route('customer.profile');
        Helpers::msg_move_page($msg,$url);
    }

    public function checkWallet(Request $request)
    {
        $this->data['status'] = 'success';
        $price_post = $request->price_post;
        $wallet = auth()->user()->wallet;
        $wallet_check = 'ok';
        if($wallet < $price_post){
            $wallet_check = 'error';
            $this->data['status'] = 'error';
        }
        $this->data['view'] = view('theme.dangtin.includes.wallet_check', compact('wallet_check'))->render();
        return response()->json($this->data);
    }

    public function wishlist()
    {
        if(auth()->check()){
            $this->data['wishlist'] = \App\Models\Wishlist::with('product')->where('user_id', auth()->user()->id)->get();
            return view('theme.customer.wishlist', ['data'=>$this->data]);
        }
        else
        {
            $wishlist = json_decode(\Cookie::get('wishlist'));

            if($wishlist != ''){
                $this->data['wishlist'] = \App\Product::whereIn('id', $wishlist)->get();
                // dd($this->data['wishlist']);
            }
            return view($this->templatePath .'.customer.wishlist', ['data'=>$this->data]);
        }
    }

    public function subscription(Request $request)
    {
        $email = $request->email;
        \App\Models\User_register_email::updateOrCreate(['email'=>$email]);
        $this->data['status'] = 'success';
        $this->data['email'] = $email;
        $this->data['view'] = view($this->templatePath .'.customer.includes.subscription')->render();
        return response()->json($this->data);
    }

    //xử lý quên mật khẩu
    public function forgetPassword(){
        return view($this->templatePath .'.customer.auth.forget-password');
    }
    public function actionForgetPassword(Request $rq){
        $user = User::where('email', $rq->email)->first();
        if($user){
            session_start();
            $customer_forget_pass_otp = new Customer_forget_pass_otp();
            $customer_forget_pass_otp->email = $rq->email;
            $customer_forget_pass_otp->user_id = $user->id;
            $customer_forget_pass_otp->otp_mail = rand(100000,999999);
            $customer_forget_pass_otp->status = 0;
            $customer_forget_pass_otp->save();
            $_SESSION["otp_forget"] = $customer_forget_pass_otp->otp_mail;
            $_SESSION["email_forget"] = $customer_forget_pass_otp->email;

            $site_name = Helpers::get_option_minhnn('site-name');
            $data = array(
                'email'=>$customer_forget_pass_otp->email,
                'emailadmin'   => $email_admin = Helpers::get_option_minhnn('email'),
                'otp'=>$customer_forget_pass_otp->otp_mail,
                'name'=>$user->first_name,
                'created_at'=>$customer_forget_pass_otp->created_at,
                'site_name' => $site_name,
            );
            Mail::send($this->templatePath .'.mail.forget-password.forget-password',
                $data,
                function($message) use ($data) {
                    $message->from($data['emailadmin'], $data['site_name']);
                    $message->to($data['email'])
                    ->subject($data['otp'].' là mã OTP của '. $data['site_name']);
                }
            );
            return redirect()->route('forgetPassword_step2');
        } else{
            redirect()->back()->withErrors('Email not exist.');
        }
    }

    public function forgetPassword_step2(){
        session_start();
        if((!isset($_SESSION["otp_forget"]) && !isset($_SESSION["email_forget"])) || $_SESSION["otp_forget"] == '' || $_SESSION["email_forget"] == '' ){
            session_unset();
            session_destroy();
            return redirect()->route('forgetPassword');
        } else{
            return view('theme.customer.auth.forget-password-step-2');
        }
    }

    public function actionForgetPassword_step2(Request $rq){
        session_start();
        $customer_forget_pass_otp = Customer_forget_pass_otp::where('otp_mail', '=', $rq->otp_mail)
        ->where('otp_mail', '=', $_SESSION["otp_forget"])
        ->where('status', '=', 0)
        ->whereRaw("TIME_TO_SEC('".Carbon::now()."') - TIME_TO_SEC(created_at) < 300 ")
        ->first();
        if($customer_forget_pass_otp){
            $_SESSION["otp_true"] = 1;
            return redirect()->route('forgetPassword_step3');
        } else{
            return redirect()->back()->withErrors('OTP is not correct.');
        }
    }

    public function forgetPassword_step3(){
        session_start();
        if((!isset($_SESSION["otp_forget"]) && !isset($_SESSION["email_forget"]) && !isset($_SESSION["otp_true"])) || $_SESSION["otp_forget"] == '' || $_SESSION["email_forget"] == '' ){
            session_unset();
            session_destroy();
            return redirect()->route('forgetPassword');
        } else{
            return view('theme.customer.auth.forget-password-step-3');
        }
    }

    public function actionForgetPassword_step3(Request $rq){
        session_start();
        $customer_forget_pass_otp = Customer_forget_pass_otp::where('email', '=', $_SESSION["email_forget"])
        ->where('otp_mail', '=', $_SESSION["otp_forget"])
        ->where('status', '=', 0)
        ->first();
        if($customer_forget_pass_otp){
            $validator = Validator::make($rq->all(), [
                'new_password'     => 'required|min:6|required_with:confirm_new_password|same:confirm_new_password',
                'confirm_new_password'     => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                ->withErrors($validator);
            }
            $customer = User::where('email', '=', $_SESSION["email_forget"])->first();
            $customer->password = bcrypt($rq->new_password);
            $customer->save();

            $customer_forget_pass_otp->status = 1;
            $customer_forget_pass_otp->save();

            session_unset();
            session_destroy();
            $msg = "Mật khẩu đã được thay đổi.";
            $url=  route('user.login');
            if($msg) echo "<script language='javascript'>alert('".$msg."');</script>";
            echo "<script language='javascript'>document.location.replace('".$url."');</script>";
        } else{
            session_unset();
            session_destroy();
            return redirect()->route('forgetPassword');
        }
    }

    public function myOrder()
    {
        $this->data['data_order'] = \App\Models\Addtocard::where('user_id', Auth::user()->id)->orderByDesc('cart_id')->paginate(10);

        $this->data['seo'] = [
            'seo_title' => 'Đơn hàng của bạn',
        ];

        return view($this->templatePath .'.customer.myorder', $this->data);
    }
    
    public function myOrderDetail($id_cart){
        $order_detail = \App\Models\Addtocard::find($id_cart);
        $this->data['order'] = $order_detail;
        $this->data['order_detail'] = \App\Models\Addtocard_Detail::where('cart_id', $this->data['order']->cart_id)->get();

        //shipping data
        $this->data['shipping_data'] = $order_detail->shipping_data ? json_decode($order_detail->shipping_data, true): [];
        $shipping_order = $order_detail->getShippingOrder;
        $this->data['shipping_order'] = $shipping_order;
        $this->data['shipping_code'] = $shipping_order->shipping_code??'';
        if($this->data['shipping_code'])
        {
            $this->data['shipping_log'] = $this->ghn_service->checkShippingOrder($this->data['shipping_code']);
        }
        //shipping data

        $total_price = isset($order_detail->total) ? $order_detail->total : 0;

        if($this->data['order']){
            $this->data['seo'] = [
                'seo_title' => 'Đơn hàng - '. $this->data['order']->cart_code,
            ];
            return view($this->templatePath .'.customer.orderdetail', [ 'data'=>$this->data ]);
        }
        else
            return view('errors.404');
    }

    public function myPoint()
    {
        $user = request()->user();
        $user_point = $user->getVIP();
        // dd($user_point);

        $this->data = [
            'user'  => $user,
            'user_point'  => $user_point,
            'seo'   =>[
                'seo_title' => 'Thông tin tài khoản',
            ]
        ];


        return view($this->templatePath .'.customer.my-point', $this->data);
    }

    /**
     * Resend email verification
     *
     * @return void
     */
    public function resendVerification()
    {
        $customer = auth()->user();
        if (!$customer->hasVerifiedEmail()) {
            return redirect(sc_route('customer.dashboard'));
        }
        $resend = $customer->sendEmailVerify();

        if ($resend) {
            return redirect()->back()->with('resent', true);
        }
    }

    function verification()
    {
        $customer = auth()->user();
        if (!$customer) 
            return redirect(url('/'));

        if($customer->getVerify && request('action') != 'sent-verify')
            return redirect(sc_route('customer.verify', ['action' => 'sent-verify']));

        if($customer->type == 3)
            $page = (new Page)->getDetail('xac-thuc-tai-khoan-affiliate', 'slug');
        else
            $page = (new Page)->getDetail('xac-thuc-tai-khoan', 'slug');

        return view($this->templatePath .'.customer.verify', [
            'user' => $customer,
            'page' => $page,
            'packages' => (new \App\Models\Package)->getListActive(),
            'options' => (new \App\Models\PackageOption)->getAllActive(),
            'seo'   =>[
                'seo_title' => 'Xác thực tài khoản',
            ]
        ]);
    }

    /**
     * Process Verification
     *
     * @param [type] $id
     * @param [type] $token
     * @return void
     */
    public function verificationProcessData(Request $request, $id = null, $token = null)
    {
        $arrMsg = [
            'error' => 0,
            'msg' => '',
            'detail' => '',
        ];
        // $customer = auth()->user();
        $customer = User::find($id);
        if (!$customer) {
            $arrMsg = [
                'error' => 1,
                'msg' => sc_language_render('customer.verify_email.link_invalid'),
            ];
        } elseif ($customer->id != $id) {
            $arrMsg = [
                'error' => 1,
                'msg' => sc_language_render('customer.verify_email.link_invalid'),
            ];
        } elseif (sha1($customer->email) != $token) {
            $arrMsg = [
                'error' => 1,
                'msg' => sc_language_render('customer.verify_email.link_invalid'),
            ];
        }
        if (! $request->hasValidSignature()) {
            // abort(401);
            return redirect(route('customer.verify'));
        }
        if ($arrMsg['error']) {
            return redirect(sc_route('customer.dashboard'))->with(['error' => $arrMsg['msg']]);
        } else {
            
            if($customer->getVerify)
                return redirect(sc_route('customer.verify', ['action' => 'sent-verify']));

            return view($this->templatePath .'.customer.verify_email', [
                'user' => $customer,
                'seo_title' => 'Xác thực tài khoản'
            ]);

            /*$customer->update(['email_verified_at' => \Carbon\Carbon::now()]);
            return redirect(sc_route('customer.dashboard'))->with(['message' => sc_language_render('customer.verify_email.verify_success')]);*/
        }
    }
    public function verificationProcess(Request $request, $id = null, $token = null)
    {
        $arrMsg = [
            'error' => 0,
            'msg' => '',
            'detail' => '',
        ];
        // $customer = auth()->user();
        $customer = User::find($id);
        
        if (!$customer) {
            $arrMsg = [
                'error' => 1,
                'msg' => sc_language_render('customer.verify_email.link_invalid'),
            ];
        } elseif ($customer->id != $id) {
            $arrMsg = [
                'error' => 1,
                'msg' => sc_language_render('customer.verify_email.link_invalid'),
            ];
        } elseif (sha1($customer->email) != $token) {
            $arrMsg = [
                'error' => 1,
                'msg' => sc_language_render('customer.verify_email.link_invalid'),
            ];
        }
        if (! $request->hasValidSignature()) {
            // abort(401);
            return redirect(route('customer.verify'));
        }

        // dd($arrMsg);

        if ($arrMsg['error'])
        {
            return redirect(sc_route('customer.dashboard'))->with(['error' => $arrMsg['msg']]);
        }
        else 
        {
            // $customer = auth()->user();
            $customer = User::find($id);
            if (!$customer) 
                return redirect(url('/'));
            
            /*if(!auth()->check())
                auth()->login($customer);*/

            $verify_folder = "/images/verify/";
            $user_id = $customer->id;

            // dd($customer->account_type);

            if($customer->account_type)
            {
                $file = request()->file('company_logo');
                $file_name = $user_id . '-' . $file->getClientOriginalName();
                $company_logo = $verify_folder . $file_name;
                $file->move( public_path().$verify_folder, $file_name );

                $file = request()->file('registration_paper');
                $file_name = $user_id . '-' . $file->getClientOriginalName();
                $registration_paper = $verify_folder . $file_name;
                $file->move( public_path().$verify_folder, $file_name );

                $dataVerify = [
                    'user_id'   => $customer->id,
                    'company_logo'  => $company_logo,
                    'registration_paper'  => $registration_paper
                ];
            }
            else{
                $file = request()->file('cccd_front');
                // dd($file);
                $file_name = $user_id . '-' . $file->getClientOriginalName();
                $cccd_front = $verify_folder . $file_name;
                $file->move( public_path().$verify_folder, $file_name );

                $file = request()->file('cccd_back');
                $file_name = $user_id . '-' . $file->getClientOriginalName();
                $cccd_back = $verify_folder . $file_name;
                $file->move( public_path().$verify_folder, $file_name );

                $file = request()->file('selfie');
                $file_name = $user_id . '-' . $file->getClientOriginalName();
                $selfie = $verify_folder . $file_name;
                $file->move( public_path().$verify_folder, $file_name );

                $dataVerify = [
                    'user_id'   => $customer->id,
                    'cccd_front'  => $cccd_front,
                    'cccd_back'  => $cccd_back,
                    'selfie'  => $selfie,
                ];
            }
            $customer->createVerify($dataVerify);
            $customer->sendEmailVerifyToAdmin();
            // $customer->update(['email_verified_at' => \Carbon\Carbon::now()]);

            return redirect(sc_route('customer.verify_sent'));
            // return redirect(sc_route('customer.verify', ['action' => 'sent-verify']));
            /*$customer->update(['email_verified_at' => \Carbon\Carbon::now()]);
            return redirect(sc_route('customer.dashboard'))->with(['message' => sc_language_render('customer.verify_email.verify_success')]);*/
        }
    }

    public function verifySent()
    {
        return view($this->templatePath .'.customer.verify-sent',[
            'seo_title' => 'Gửi yêu cầu xác thực thành công'
        ]);
    }

    public function author()
    {
        // $users = User::where('status', 1)->where('expert', 1)->paginate(20);
        $this->data['page'] = \App\Page::where('slug', 'tac-gia')->firstOrFail();
        $this->data['users'] = \App\User::where('status', 1)->where('expert', 1)->orderByDesc('created_at')->paginate(21);
        $this->data['seo'] = [
            'seo_title' => 'Tác giả',
            'seo_image' => asset( setting_option('share-image') ),
            'seo_description'   => '',
            'seo_keyword'   => '',
        ];

        return view($this->templatePath .'.author.index', $this->data);
    }
    public function authorDetail($id)
    {
        $user = User::where('id', $id)->first();
        if($user)
        {
            $this->data['user'] = $user;
            $products = (new ShopProduct)->getList([
                'user_id'   => $user->id,
                'post_type' => ['buy', 'sell']
            ]);
            // dd($user->posts);
            $dataReponse = [
                'user'  => $user,
                'posts'  => $products,
                'seo_title' => 'Trang tác giả',
                'seo_image' => asset( setting_option('share-image') ),
                'seo_description'   => '',
                'seo_keyword'   => '',
            ];

            if($user->pro == 1)
                return view($this->templatePath .'.author.detail-pro', $dataReponse);
            else
                return view($this->templatePath .'.author.detail', $dataReponse);
        }
    }

    public function affiliate()
    {
        $invite_code = auth()->user()->getCodeInvite();
        $user  = User::find(auth()->user()->id);
        return view($this->templatePath .'.customer.affiliate',[
            'user'  => $user,
            'user_invited'  => $user->getInvited,
        ]);
    }

    public function acceptInvite()
    {
        $user = auth()->user();
        // dd(request()->all());
        if($user && request('invite_code'))
        {
            $user->update([
                'invited_code'   => request('invite_code')??''
            ]);
            return redirect()->back()->with(['message_invite' => 'Nhập mã giới thiệu thành công']);
        }
        return redirect()->back()->with(['message_invite_error' => 'Mã giới thiệu không đúng hoặc không tồn tại']);
    }

    public function chaogia($id)
    {
        $dataReponse = [
            'user'   => auth()->user()
        ];
        return view($this->templatePath .'.author.contact', $dataReponse);
    }
    public function chaogiaProcess($id)
    {
        $data = request()->all();
        $validator = $this->validator($data);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data['to_user_id'] = $id; // 'yeu cau chao gia'
        $data['user_id'] = auth()->user()->id;

        if(isset($data['request_file']))
        {
            $folderPath = '/images/contact-file';

            $file = request()->file("request_file");

            $filename_original = $file->getClientOriginalName();
            $filename_ = pathinfo($filename_original, PATHINFO_FILENAME);
            $extension_ = pathinfo($filename_original, PATHINFO_EXTENSION);

            $file_slug = Str::slug($filename_);
            $file_name = uniqid() . '-' . $file_slug . '.' . $extension_;
            $request_file = $folderPath . '/' . $file_name;

            $data['request_file']   = $request_file;

            $data['attach']['fileAttach'][] = [
                    'file_path' => asset($request_file),
                    'file_name' => $filename_
            ];
            
            $file->move(public_path().$folderPath, $file_name);
        }
        
        $contact = (new \App\Models\ShopContact)->createContact($data, $type='user');
        if($contact)
            return redirect(url()->current())->with(['message' => 'Gửi yêu cầu chào giá thành công']);
    }

    protected function validator(array $data)
    {
        $validation_rules = array(
            'request_file' => 'max:10240',
        );
        $messages = array(
            'request_file.max' => 'File quá lớn, vui lòng chọn file nhỏ hơn 10MB',
        );

        return Validator::make($data,  $validation_rules, $messages);
    }

    public function vote()
    {
        $data = request()->all();
        $data['user_id'] = auth()->user()->id;
        $check_vote = \App\Models\UserVote::where('user_id', $data['user_id'])->where('user_vote', $data['user_vote'])->first();
        if(!$check_vote)
        {
            $create = \App\Models\UserVote::create($data);
            if($create)
            {
                $user = User::find($data['user_vote']);
                return response()->json([
                    'error' => 0,
                    'view'  => view($this->templatePath . '.author.author-vote',['user' => $user])->render(),
                ]);
            }
        }
    }
}



