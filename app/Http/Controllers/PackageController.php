<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page as Page;
use Illuminate\Support\Facades\View;
use Gornymedia\Shortcodes\Facades\Shortcode;
use App\Models\PaymentRequest;
use Mail;
use App\Models\ShopEmailTemplate;
use App\Mail\SendMail;
use App\Jobs\Job_SendMail;
use \App\Models\Package;
use \App\Models\PackageOption;
use \App\Models\PackageDay;
use \App\Models\PackageDayJoin;

class PackageController extends Controller {
    use \App\Traits\LocalizeController;
    
    public $data = [];

    //nap tien
    public function package()
    {
        if(auth()->check() && !auth()->user()->isVerified())
            return redirect(route('customer.verify'));
        $data = [
            'packages' => (new Package)->getListActive(),
            'seo' => [
                'seo_title' => 'Nâng cấp tài khoản',
            ],
            'packages' => Package::where('status', 1)->orderby('sort')->get(),
            'options' => (new PackageOption)->getAllActive(),
            'packagedays' => (new PackageDay)->get()
        ];
        return view($this->templatePath .'.package.index', $data);
    }

    public function purchaseDetail($code)
    {
        // dd($code);
        $user = request()->user();
        $payment = PaymentRequest::where('payment_code', $code)->firstorfail();

        if($payment)
        {
            $package = Package::find($payment->package_id);

            $this->data['user'] = $user;
            $this->data['payment'] = $payment;
            $this->data['package'] = $package;
            $this->data['packages'] = Package::where('status', 1)->orderby('sort')->get();

            $this->data['seo']  = [
                'seo_title' =>  'Đơn hàng '. $payment->payment_code,
            ];

            return view($this->templatePath .'.package.purchase_single', $this->data);
        }
    }

    public function purchaseProcess($id)
    {
        $day_id = request('day');
        if(!$day_id)
            return redirect( sc_route('account_upgrade'))->with(['error' => 'Không tìm thấy gói nâng cấp!']);
        
        $package = Package::findorfail($id);
        $package_day = PackageDay::find($day_id);
        $package_day_item = PackageDayJoin::where('package_id', $id)->where('day_id', $day_id)->first();

        if(!$package_day_item)
            return redirect( sc_route('account_upgrade') );

        $user = request()->user();

        $amount = $package_day_item->getFinalPrice();

        $now = \Carbon\Carbon::now();
        $date_check = $now->subDay()->format('Y-m-d H:i');
        
        $payment = PaymentRequest::where('user_id', $user->id)->where('package_id', $package->id)->where('day_id', $day_id)->where('created_at', '>=', $date_check)->where('status', 0)->first();
        
        $code = $payment->payment_code??'';
        $orderUrl = route('purchase_checkout.detail', $code);
        if(!$payment)
        {
            $payment = PaymentRequest::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'day_id' => $day_id,
                'amount' => $amount,
                'status' => 0,
                'payment_status' => $package->name,
                'payment_code' => auto_code('GTC'),
                'payment_success' => 0,
            ]);
            $code = auto_code('GTC', $payment->id);
            $code = $package->code . $package_day->day . $code ;
            // dd($code);
            $payment->payment_code = $code;
            $payment->save();

            $orderUrl = route('purchase_checkout.detail', $code);

            $checkContent_admin = ShopEmailTemplate::where('group', 'order_to_admin')->where('status', 1)->first();
            $checkContent_user = ShopEmailTemplate::where('group', 'order_to_user')->where('status', 1)->first();
            if($checkContent_admin && $checkContent_user)
            {
                $email_admin       = setting_option('email_admin');
                $company_name      = setting_option('company_name');
                
                $content_admin = htmlspecialchars_decode($checkContent_admin->text);
                $content_user = htmlspecialchars_decode($checkContent_user->text);

                $dataFind = [
                    '/\{\{\$orderID\}\}/',
                    '/\{\{\$productName\}\}/',
                    '/\{\{\$userName\}\}/',
                    '/\{\{\$userEmail\}\}/',
                    '/\{\{\$userPhone\}\}/',
                    '/\{\{\$subtotal\}\}/',
                    '/\{\{\$total\}\}/',
                    '/\{\{\$receive\}\}/',
                    '/\{\{\$orderDetail\}\}/',
                    '/\{\{\$comment\}\}/',
                    '/\{\{\$userAddress\}\}/',
                    '/\{\{\$bankInfo\}\}/',
                    '/\{\{\$orderCreated\}\}/',
                    '/\{\{\$orderStatus\}\}/',
                    '/\{\{\$orderUrl\}\}/',
                ];
                $dataReplace = [
                    $code ?? '',
                    '<b>Gói tin</b>: '. ($package->name ?? '') . '<br/>',
                    $user->fullname ?? '',
                    $user->email ?? '',
                    $user->phone ?? '',
                    render_price($amount ?? 0),
                    render_price($amount ?? 0),
                    '',
                    '',
                    '',
                    $user->address ?? '',
                    setting_option('thong-tin-chuyen-khoan'),
                    $payment->created_at,
                    $payment->statusText(),
                    $orderUrl
                ];
                $content = preg_replace($dataFind, $dataReplace, $content_user);
                $content_admin = preg_replace($dataFind, $dataReplace, $content_admin);
                // dd($content);

                $subject = str_replace('$orderID', $code, $checkContent_user->subject);
                $subject_admin = str_replace('$orderID', $code, $checkContent_admin->subject);

                $dataView = [
                    'content' => $content,
                ];
                $config = [
                    'to' => $user->email,
                    'subject' => $subject,
                ];

                $dataView_sys = [
                    'content' => $content_admin,
                ];
                $config_sys = [
                    'to' => $email_admin,
                    'subject' => $subject_admin,
                ];

                $send_mail = new SendMail( 'email.content', $dataView, $config );
                Mail::send($send_mail);
                /*$sendEmailJob = new Job_SendMail($send_mail);
                dispatch($sendEmailJob)->delay(now()->addSeconds(5));*/

                $send_mail_admin = new SendMail( 'email.content', $dataView_sys, $config_sys );
                Mail::send($send_mail_admin);
                /*$sendEmailJob_admin = new Job_SendMail($send_mail_admin);
                dispatch($sendEmailJob_admin)->delay(now()->addSeconds(3));*/
            }
        }

        return redirect($orderUrl);
    }

    public function purchasePayment()
    {
        $data_request = request()->all();
        $payment_id = $data_request['payment_id'];
        // dd($data);

        $payment = PaymentRequest::where('id', $payment_id)->firstorfail();

        if($payment)
        {
            $package = Package::find($payment->package_id);
            $user = \App\User::find($payment->user_id);
            if($user->province)
                $province = Province::find($user->province);
            $data = [
                'payment_method' => $data_request['payment_method'],
                'payment_code' => $payment->payment_code,
                'cart_total' => $payment->amount,
                'name' => $user->fullname,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'user_id' => $user->id,
                'state_province' => !empty($province) ? $province->name : 'HCM',
            ];

            return (new \App\Http\Controllers\PaymentController)->alepay_checkout($data, $cart_id=0);
        }
    }

    public function paymentType(Request $request)
    {
        $type = $request->type;
        $this->data['payment_type'] = $type;

        $templateName = $this->templatePath .'.payment.includes.' . $type;
        if (View::exists($templateName)) 
        {
            $this->data['view'] = view($templateName,  $this->data)->render();
            return response()->json($this->data);
        }
        else
        {
            $templateName = $this->templatePath .'.recharge.includes.' . $type;
            if (View::exists($templateName)) 
            {
                $this->data['view'] = view($templateName,  $this->data)->render();
                return response()->json($this->data);
            }
        }
        /*
        $type = $request->type;
        $this->data['payment_type'] = $type;
        if($type == 'qrcode'){
            $view = view('theme.payment.includes.qrcode')->render();
        }
        elseif($type == 'atm'){
            $view = view('theme.payment.includes.banks')->render();
        }
        elseif($type == 'visa'){
            $view = view('theme.payment.includes.visa')->render();
        }
        $this->data['view'] = $view;
        return response()->json($this->data);*/
    }

    public function paymentPointCheckout()
    {
        $data = request()->all();
        $id = request('package_id');
        $package = Package::find($id);
        $user = request()->user();
        // dd($package);
        if($package)
        {
            $amount = $package->price > 0 ? str_replace(',', '', $package->price) * 100 : 0;
            if($amount > 0){
                $request_bank_code = $data['bank_code'] ??'VNPAYQR';
                $dataPayment = [
                    'package_id' => $id, 
                    'user_id' => $user->id, 
                    'amount' => $amount / 100,
                    'content' => $data['content'] ?? '',
                    'bank_code' => $request_bank_code,
                    'status' => 0,
                    'payment_status' => 'Thanh toán gói tin',
                    'payment_method' => 'VNPay',
                ];

                try {
                    $dataPayment['payment_method'] = ($data['bank_code'] != 'VNPAYQR') ? 'VNPay Bank' : 'VNPay QR';
                    
                    $payment_create = PaymentRequest::create($dataPayment);

                    $vnp_TmnCode = env('VNPAY_TmnCode');
                    $purchase = array(
                        "vnp_Version" => "2.1.0",
                        "vnp_Command" => "pay",
                        "vnp_CreateDate" => date('YmdHis'),
                        "vnp_CurrCode" => "VND",
                        'vnp_TxnRef' => $payment_create->id,
                        'vnp_IpAddr' => '127.0.0.1',
                        'vnp_OrderInfo' => $request->content ?? 'Thanh toán gói tin',
                        'vnp_Locale' => 'vn',
                        'vnp_OrderType' => 'other',
                        'vnp_Amount' => $amount,
                        'vnp_ReturnUrl' => route('payment.return'),
                        "vnp_TmnCode" => $vnp_TmnCode,
                    );
                    if($request_bank_code!='qrcode'){
                        $purchase['vnp_BankCode'] = $request_bank_code;
                    }
                    
                    $vnp_Url = $this->getPurchaseVNPay($purchase);
                    // dd($vnp_Url);
                    PaymentRequest::where('id', $payment_create->id)->update(['payment_url'=> $vnp_Url]);

                    if ($vnp_Url) {
                        return redirect($vnp_Url);
                    } else {
                        // not successful
                        return $response->getMessage();
                    }
                }
                catch(Exception $e) {

                    return $e->getMessage();
                }
            }
            else
                return view('errors.404');
        }
    }

    public function getPurchaseVNPay($purchase)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        // $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
        $vnp_HashSecret = env('VNPAY_HashSecret');

        ksort($purchase);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($purchase as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }

    public function paymentHistory()
    {
        $data['user'] = request()->user();
        $data['payments'] = PaymentRequest::where('user_id', $data['user']->id)->get();
        // ddd($data['payments']);

        $data['seo'] = [
            'seo_title' => 'Lịch sử thanh toán',
        ];
        return view($this->templatePath . '.payment.payment-history', $data);
    }

    public function purchaseCancel($id)
    {
        $user = request()->user();
        $payment = PaymentRequest::where('id', $id)->update(['status' => 3]);
        return redirect(route('purchase'));
    }
}
