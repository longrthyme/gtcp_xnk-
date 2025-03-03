<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Product;
use Mail;
use App\Models\ShopEmailTemplate;
use App\Mail\SendMail;
use App\Jobs\Job_SendMail;

use App\Services\VNPayService;
use App\Models\PaymentRequest;

class PurchaseController extends Controller
{
    use \App\Traits\LocalizeController;
    
    public $data = [];

    protected $vnpay;

    public function __construct()
    {
        parent::__construct();
        $this->vnpay = new VNPayService;
    }

    //nap tien
    public function package()
    {
        $this->localized();
        $this->data['seo'] = [
            'seo_title' => 'Gói VIP',
        ];
        $this->data['packages'] = Package::where('status', 1)->orderby('sort')->get();
        return view($this->templatePath .'.package.purchase', $this->data);
    }

    public function purchaseDetail($code)
    {
        $user = auth()->user();
        $payment = PaymentRequest::where('payment_code', $code)->firstorfail();

        if($payment)
        {
            $package = (new Product)->getDetail($payment->package_id);

            $this->data['user'] = $user;
            $this->data['payment'] = $payment;
            $this->data['package'] = $package;
            // $this->data['packages'] = Product::where('status', 1)->orderby('sort')->get();

            $this->data['seo']  = [
                'seo_title' =>  'Đơn hàng '. $payment->payment_code,
            ];

            return view($this->templatePath .'.purchase.purchase_single', $this->data);
        }
    }

    public function purchase()
    {
        $id = request('id')??0;
        $product = (new Product)->getDetail($id);
        if(!$product)
        {
            return response()->view('errors.404', ['seo_title' => 'fdfdas'], 404);
        }
        $this->data['seo'] = [
            'seo_title' => $product->name,
        ];

        $user = auth()->user();

        $amount = $product->price ?? 0;

        $now = \Carbon\Carbon::now();
        $date_check = $now->subDay()->format('Y-m-d H:i');

        $payment = PaymentRequest::create([
            'user_id' => $user->id,
            'package_id' => $product->id,
            'amount' => $amount,
            'status' => 0, // ma yeu cau nap tien
            'payment_status' => $product->name,
            'payment_code' => auto_code('IMS'),
            'payment_success' => 0,
        ]);
        $code = auto_code('IMS', $payment->id);
        PaymentRequest::find($payment->id)->update([
            'payment_code' => $code,
        ]);
        // dd($payment);

        return redirect(route('purchase.checkout', $code));
    }

    public function payment()
    {
        $data = request()->all();
        $payment_id = $data['payment_id'];
        // dd($data);

        if(!$data['payment_method'])
            return redirect()->back();
        $payment_method_arr = explode('__', $data['payment_method']);
        $payment_gate = $payment_method_arr[0]??'';
        $payment_method = $payment_method_arr[1]??'';

        if(!empty($data['bank_code']) && $data['bank_code'] !='')
            $payment_method = $data['bank_code'];

        if($payment_gate == '' || $payment_method == '')
            return redirect()->back();

        $payment = PaymentRequest::where('id', $payment_id)->firstorfail();

        if($payment)
        {
            $user = \App\User::find($payment->user_id);
            if($user->province)
                $province = \App\Models\LocationProvince::find($user->province);
            $dataReponse = [
                'payment_method' => $payment_method,
                'payment' => $payment,
                'name' => $user->fullname,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'user_id' => $user->id,
                'state_province' => !empty($province) ? $province->name : 'HCM',
            ];
            // dd($dataReponse);
            if($payment_gate == 'vnpay')
            {
                $response_url = $this->vnpay->createPayment($dataReponse);
                if($response_url)
                    return redirect($response_url);
            }
        }
    }

    public function paymentComplete($payment_id = 0)
    {
        $payment = PaymentRequest::where('id', $payment_id)->where('send_mail', 0)->first();
        if($payment)
        {
            $code = $payment->payment_code;
            $user = \App\User::find($payment->user_id);
            $product = (new Product)->getDetail($payment->package_id);

            $checkContent = ShopEmailTemplate::where('group', 'order_payment_success_user')->where('status', 1)->first();
            $checkContent_admin = ShopEmailTemplate::where('group', 'order_to_admin')->where('status', 1)->first();
            
            if($checkContent_admin && $checkContent)
            {
                $email_admin       = setting_option('email_admin');
                $company_name      = setting_option('company_name');
                
                $content_user = htmlspecialchars_decode($checkContent->text);
                $content_admin = htmlspecialchars_decode($checkContent_admin->text);

                $orderUrl = route('purchase.checkout', $code);

                $payment_status = $payment->status == 1 ? sc_language_render('payment.paid') : sc_language_render('payment.unpaid');

                $dataFind = [
                    '/\{\{\$invoiceID\}\}/',
                    '/\{\{\$orderUrl\}\}/',
                    '/\{\{\$productName\}\}/',
                    '/\{\{\$userName\}\}/',
                    '/\{\{\$userEmail\}\}/',
                    '/\{\{\$userPhone\}\}/',
                    '/\{\{\$userAddress\}\}/',
                    '/\{\{\$total\}\}/',
                    '/\{\{\$orderCreated\}\}/',
                    '/\{\{\$orderStatus\}\}/',
                ];
                $dataReplace = [
                    $code ?? '',
                    $orderUrl,
                    $product->name,
                    $user->fullname ?? '',
                    $user->email ?? '',
                    $user->phone ?? '',
                    $user->address ?? '',
                    render_price($payment->amount ?? 0),
                    date('H:i d-m-Y', strtotime($payment->created_at)),
                    $payment_status

                ];
                $content = preg_replace($dataFind, $dataReplace, $content_user);
                $content_admin = preg_replace($dataFind, $dataReplace, $content_admin);

                $subject = str_replace('$invoiceID', $code, $checkContent['subject']);
                $subject_admin = str_replace('$invoiceID', $code, $checkContent_admin['subject']);

                // dd($content);
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
                // Mail::send($send_mail);
                $sendEmailJob = new Job_SendMail($send_mail);
                dispatch($sendEmailJob);

                $send_mail_admin = new SendMail( 'email.content', $dataView_sys, $config_sys );
                // Mail::send($send_mail_admin);
                $sendEmailJob_admin = new Job_SendMail($send_mail_admin);
                dispatch($sendEmailJob_admin);

                PaymentRequest::find($payment_id)->update([
                    'send_mail' => 1
                ]);
            }
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
    }

    public function history()
    {
        $data['user'] = request()->user();
        $data['payments'] = PaymentRequest::where('user_id', $data['user']->id)->orderbyDesc('id')->get();
        // ddd($data['payments']);

        $data['seo'] = [
            'seo_title' => 'Lịch sử thanh toán',
        ];
        return view($this->templatePath . '.purchase.payment-history', $data);
    }

    public function cancel($id)
    {
        $user = request()->user();
        PaymentRequest::find($id)->update(['status' => 3]);
        $payment = PaymentRequest::find($id);
        // dd($payment);
        return redirect(route('purchase.checkout', $payment->payment_code));
    }

    
    public function paymentSuccess()
    {
        $this->localized();
        $this->data['payment'] = PaymentRequest::where('status', '<>', 1)->where('user_id', auth()->user()->id)->orderbyDesc('id')->first();

        return view('theme.payment.success', $this->data);
    }
}
