<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class VNPayService
{
    private $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    private $vnp_ReturnUrl;
    private $vnp_TmnCode = "7VPWNO1S"; // Mã website tại VNPAY 
    private $vnp_HashSecret = "4MGV1D6BRPGGP2CPTRRRNVT2KV6POY01"; // Chuỗi bí mật mới

    public function __construct()
    {
        $this->vnp_ReturnUrl = "https://db13-2405-4802-9055-6a70-cce0-fc37-408c-388e.ngrok-free.app/checkout/vnpay-return";
        if (str_contains($this->vnp_ReturnUrl, 'ngrok-free.app')) {
            $this->vnp_ReturnUrl .= (parse_url($this->vnp_ReturnUrl, PHP_URL_QUERY) ? '&' : '?') . 'ngrok-skip-browser-warning=true';
        }
    }

    private function sortArray(&$arr) {
        ksort($arr);
    }

    public function createPaymentUrl($orderId, $amount, $orderInfo)
    {
        $vnp_TxnRef = $orderId; // Mã giao dịch
        $vnp_Amount = $amount * 100; // Số tiền * 100 
        $vnp_Locale = 'vn'; // Ngôn ngữ
        $vnp_BankCode = ''; // Mã ngân hàng
        $vnp_IpAddr = request()->ip(); // IP khách hàng
        $userId = auth()->id(); // Lấy user ID hiện tại
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $orderInfo,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => url('/checkout/vnpay-return') . "?user_id=" . $userId, // Thêm user_id vào URL return
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if ($vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Thêm vnp_SecureHash vào cuối URL
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
        $query .= 'vnp_SecureHash=' . $vnpSecureHash;

        return $this->vnp_Url . "?" . $query;
    }

    public function validateReturn($vnp_ResponseCode)
    {
        // Log response code để debug
        Log::info('VNPay Response Code: ' . $vnp_ResponseCode);
        return $vnp_ResponseCode == "00";
    }
}