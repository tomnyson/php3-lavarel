<?php

namespace App\Http\Controllers;

use App\Models\User;
use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::content();
        return view('checkout.index', compact('carts'));
    }

    function cartTotalAsNumber()
    {
        return floatval(preg_replace('/[^\d.]/', '', Cart::total()));
    }


    public function vnpayReturn(Request $request)
    {
        $vnp_SecureHash = $request->vnp_SecureHash;
        var_dump($request->all());
        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                $order = Order::where('id', $request->vnp_TxnRef)->first();
                $order->update(['status' => 'paid']);
                // Payment success
                return view('checkout.paymentSuccess', compact('order'));
            } else {
                // Payment failed
                return view('checkout.paymentFailed');
            }
        } else {
            // Invalid hash
            return view('payment.invalid');
        }
    }
    public function createPayment(Request $request)
    {
        $vnp_TmnCode = env('VNPAY_TMN_CODE');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $vnp_Url = env('VNPAY_URL');
        $vnp_Returnurl = env('VNPAY_RETURN_URL');

        $vnp_TxnRef = time(); // Mã đơn hàng
        $vnp_OrderInfo = 'Thanh toan don hang test';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $this->cartTotalAsNumber(); // Số tiền thanh toán
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

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

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'email' => 'required|email',
            "payment" => "required"
        ]);

        $user_id = Auth::user()->id;
        $total =  $this->cartTotalAsNumber();
        $order = Order::create(array(
            'user_id' => $user_id,
            'total' =>  $total,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
            'name' => $request->name,
            'order_status' => 'pending',

        ));
        // theme cart item 
        foreach (Cart::content() as $item) {
            var_dump($item);
            $orderItem = OrderItem::create(array(
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->qty,
                'price' => $item->price,
            ));
        }
        Cart::destroy();
        Mail::to($request->user())->send(new OrderShipped($order));
        if ($request->payment == "vnpay") {
            echo "call here to checkout your";
            return $this->createPayment($request);
        } else {
            return view('checkout.checkoutTK');
        }
    }
}
