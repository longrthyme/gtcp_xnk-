<?php

namespace App\Services;

// use Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Models\PaymentRequest;
use App\Models\Addtocard;
use Stevebauman\Location\Facades\Location;
use App\Http\Controllers\CartController;
use Carbon\Carbon;

class VNPayService
{
	private $configs;
	// Chứa context của API
    private $apiContext;
    // Chứa danh sách các item (mặt hàng)
    private $itemList;
    // Đơn vị tiền thanh toán
    private $paymentCurrency;
    // Tổng tiền của đơn hàng
    private $totalAmount;
    // Đường dẫn để xử lý một thanh toán thành công
    private $returnUrl;
    // Đường dẫn để xử lý khi người dùng bấm cancel (không thanh toán)
    private $cancelUrl;

    public function __construct()
    {
    	// Đọc các cài đặt trong file config
        $this->configs = sc_payment_setting('vnpay');

        // Set mặc định đơn vị tiền để thanh toán
        $this->paymentCurrency = session('currency') ?? setting_option('currency');;

        $this->totalAmount = 0;
    }

    /**
     * Set payment currency
     *
     * @param string $currency String name of currency
     * @return self
     */
	public function setCurrency($currency)
    {
    	$this->paymentCurrency = $currency;

        return $this;
    }

    /**
     * Get current payment currency
     *
     * @return string Current payment currency
     */
    public function getCurrency()
    {
        return $this->paymentCurrency;
    }

    public function createPayment($data) 
    {
        $create_date = Carbon::now()->addHours(3)->format('YmdHis');
        $expire = Carbon::now()->addHours(4)->format('YmdHis');
        // dd($expire);

        $cart_id = $data['cart_id']??0;
        
        $payment = $data['payment'];
        $amount = $payment->amount??0;

        $amount = str_replace(',', '', $amount) * 100;
    
        $product = (new \App\Product)->getDetail($payment->package_id);

        try {
            $vnp_TmnCode = $this->configs['vnp_TmnCode'];

            $purchase = array(
                "vnp_Version" => "2.1.0",
                "vnp_Command" => "pay",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $amount,
                "vnp_CreateDate" => $create_date,
                "vnp_CurrCode" => "VND",
                'vnp_IpAddr' => \Request::ip(),
                "vnp_Locale" => 'vn',
                "vnp_OrderInfo" => "Thanh toan khoa hoc ". $product->id??0,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => route('payment_vnpay.return'),
                'vnp_ExpireDate'    => $expire,
                "vnp_TxnRef" => $payment->id,
            );
            if(!empty($data['payment_method']))
            {
                $purchase['vnp_BankCode'] = $data['payment_method'];
            }
            // dd($purchase);
            $vnp_Url = $this->getPurchaseVNPay($purchase);

            PaymentRequest::find($payment->id)->update([
                'payment_method'    => 'VNPAY ' .$data['payment_method'],
                'payment_url'    => $vnp_Url,
            ]);

            if ($vnp_Url)
            {
                return $vnp_Url;
            }
            else
            {
                // not successful
                return $response->getMessage();
            }

        } catch(Exception $e) {

            return $e->getMessage();
        }
        
        // return view('theme.home', ['data' => $this->data]);
    }

    public function getPurchaseVNPay($purchase)
    {
        // $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Url = $this->configs['payment_url'];
        $vnp_HashSecret = $this->configs['secretKey'];

        $getSecureHash = $this->getSecureHash($purchase);

        $vnp_Url = $vnp_Url . "?" . $getSecureHash['query'];
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   $getSecureHash['vnpSecureHash'];
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }
    public function getSecureHash($purchase)
    {
        $vnp_HashSecret = $this->configs['secretKey'];
        unset($purchase['vnp_SecureHash']);
        ksort($purchase);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($purchase as $key => $value) 
        {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        return [
            'hashdata' => $hashdata,
            'query' => $query,
            'vnpSecureHash' => $vnpSecureHash,
        ];
    }
}