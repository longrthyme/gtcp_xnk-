<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\VNPayService;
use App\Models\PaymentRequest;
use App\Models\VNPayLog;
use App\Product;
use App\Http\Controllers\PurchaseController;

class VNPayController extends Controller
{
    use \App\Traits\LocalizeController;
    protected $vnpay;

    public function __construct()
    {
        parent::__construct();
        $this->vnpay = new VNPayService;
    }

    public function paymentReturn()
    {
        $this->localized();
        $this->data['user'] = auth()->user();
        $this->data['title'] = 'Thanh toán đơn hàng';
        $this->data['seo'] = [
            'seo_title' => 'Thanh toán đơn hàng'
        ];
        $inputData = array();
        $response = request()->all();
        $this->data['response'] = $response;
        foreach ($response as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];

        $getSecureHash = $this->vnpay->getSecureHash($inputData);
        $secureHash = $getSecureHash['vnpSecureHash'];

        $payment_id = $response['vnp_TxnRef'];
        $payment = PaymentRequest::where('id', $payment_id)->where('status', 1)->first();
        
        if($payment && $secureHash == $vnp_SecureHash)
        {
            // $this->data['cart'] = \App\Model\Addtocard::find($payment->cart_id);
            $this->data['payment'] = $payment;
            $this->data['product'] = (new Product)->getDetail($payment->package_id);
            $payment_status = $response['vnp_TransactionStatus'] == '00' ? 'GD Thành công' : 'GD không thành công';
            
            if ($response['vnp_TransactionStatus'] == '00') {
                (new PurchaseController)->paymentComplete($payment->id);

                // TODO: xử lý kết quả và hiển thị.
                return view($this->templatePath .'.purchase.success', $this->data);
                
            } else {
                return view($this->templatePath .'.purchase.reject', $this->data);
            }
        }
        else {
            $this->data['payment'] = PaymentRequest::find($payment_id);
            $this->data['message'] = 'Invalid signature';
            
            return view($this->templatePath .'.purchase.payment_error', $this->data);
        }
    }

    public function payment_ipn()
    {
        $this->localized();

        $inputData = array();
        $returnData = request()->all();
        
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];

        $getSecureHash = $this->vnpay->getSecureHash($inputData);
        $secureHash = $getSecureHash['vnpSecureHash'];

        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi
        
        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];
        
        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);

                $payment_data = PaymentRequest::find($orderId);
        
                // $order = NULL;
                if ($payment_data) {
                    //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    if($payment_data->amount == $vnp_Amount) 
                    {
                        if ($payment_data->status != '' && $payment_data->status == 0)
                        {
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00')
                            {
                                $Status = 1; // Trạng thái thanh toán thành công
                                $payment_status = 'Giao dịch thành công';
                            }
                            else
                            {
                                $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                                $payment_status = 'Giao dịch thất bại';
                            }
                            
                            //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                            $data_db = [
                                'transaction_no' => $returnData['vnp_TransactionNo'] ?? '',
                                'content' => $returnData['vnp_OrderInfo'] ?? '',
                                'status' => $Status,
                                'payment_success' => $Status,
                                'payment_status' => $payment_status??'Unknow',
                                'bank_code' => $vnp_BankCode
                            ];
                            
                            PaymentRequest::find($orderId)->update($data_db);
                            //
                            //
                            //
                            //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công                
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    }
                    else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }

        //log merchant
        $data_log = [
            'response_code'    => $returnData['RspCode']??'',
            'message'    => $returnData['Message']??'',
            'ip'    => request()->ip(),
            'data'  => json_encode($returnData, JSON_UNESCAPED_UNICODE)
        ];
        Log::info('Payment error: '.$returnData['RspCode']);
        // Log::debug('log merchant: '. json_encode($data_log, JSON_UNESCAPED_UNICODE));
        VNPayLog::create($data_log);

        //Trả lại VNPAY theo định dạng JSON
        // echo json_encode($returnData);
        return response()->json($returnData);

    }

    public function getResponseCode()
    {
        return [
            '00' =>  'Giao dịch thành công',
            '07' =>  'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
            '09' =>  'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.',
            '10' =>  'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
            '11' =>  'Giao dịch không thành công do: Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch.',
            '12' =>  'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.',
            '13' =>  'Giao dịch không thành công do Quý khách nhập sai mật khẩu xác thực giao dịch (OTP). Xin quý khách vui lòng thực hiện lại giao dịch.',
            '24' =>  'Giao dịch không thành công do: Khách hàng hủy giao dịch',
            '51' =>  'Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.',
            '65' =>  'Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.',
            '75' =>  'Ngân hàng thanh toán đang bảo trì.',
            '79' =>  'Giao dịch không thành công do: KH nhập sai mật khẩu thanh toán quá số lần quy định. Xin quý khách vui lòng thực hiện lại giao dịch',
            '99' =>  'Các lỗi khác (lỗi còn lại, không có trong danh sách mã lỗi đã liệt kê)'
        ];
    }
}
