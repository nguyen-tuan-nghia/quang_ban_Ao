<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\delivery;
use App\Models\order;
use App\Models\ship;
use App\Models\order_detail;
use App\Models\star_rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class cartController extends Controller
{
    public function vnpay()
    {
        session(['cost_id' => Auth::user()->id]);
        session(['url_prev' => url()->previous()]);
        $vnp_TmnCode = "4YRXJ0M4"; //Mã website tại VNPAY
        $vnp_HashSecret = "ZNPIJXZUNNDFISGRJUOGWOOVYFZRUFIG"; //Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = url("/return-vnpay");
        $vnp_TxnRef = date("YmdHis"); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = 1000 * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

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
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
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
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        // return redirect($vnp_Url);
        header('Location: ' . $vnp_Url);
        die();
    }
    public function returnvnpay(Request $request)
    {
        $url = session('url_prev', '/');
        if ($request->vnp_ResponseCode == "00") {
            $this->apSer->thanhtoanonline(session('cost_id'));
            return redirect($url)->with('success', 'Đã thanh toán phí dịch vụ');
        }
        session()->forget('url_prev');
        return redirect($url)->with('errors', 'Lỗi trong quá trình thanh toán phí dịch vụ');
    }
    public function star_store(Request $request)
    {
        $star_rating = star_rating::where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)->where('customer_id', Auth::user()->id)->first();
        if ($star_rating) {
            $star_rating->star = $request->star;
            $star_rating->save();
        } else {
            $new = new star_rating();
            $new->product_id = $request->product_id;
            $new->order_id = $request->order_id;
            $new->star = $request->star;
            $new->customer_id = Auth::user()->id;
            $new->save();
        }
    }
    public function status($id)
    {
        $order = order::find($id);
        if (Auth::user()->id == $order->user_id) {
            if ($order->status == 0) {
                $order->status = 3;
                $order->save();
            }
        }
        return redirect('/cart/history');
    }
    public function history_detail($id)
    {
        $ship = ship::where('order_id', $id)->first();
        $order = order::where('id', $id)->first();
        $order_detail = order_detail::where('order_id', $id)->with('product')->with('gallery')->orderBy('id', 'DESC')->get();
        return view('public.cart.history_detail')->with(compact('order', 'ship', 'order_detail'));
    }
    public function history()
    {
        $order = order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('public.cart.history')->with(compact('order'));
    }
    public function order(Request $request)
    {
        $this->validate($request, [
            'receiver' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'location' => 'required',
        ]);
        $order = new order();
        $order->user_id = Auth::user()->id;
        $order->status = 0;
        $order->payment_type = $request->payment_type;
        $order->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $order->save();
        foreach (Cart::content() as $key => $val) {
            $order_detail = new order_detail();
            $order_detail->order_id = $order->id;
            $order_detail->product_id = $val->id;
            $order_detail->quantity = $val->qty;
            $order_detail->price = $val->price;
            $order_detail->created_at = Carbon::now('Asia/Ho_Chi_Minh');;
            $order_detail->save();
        }
        $ship = new ship();
        $ship->order_id = $order->id;
        $ship->name = $request->receiver;
        $ship->phone = $request->phone;
        $ship->note = $request->note;
        $ship->city = $request->city;
        $ship->price = session()->get('fee');
        $ship->address = $request->location;
        $ship->save();
        session()->forget('fee');
    }
    public function delivery(Request $request)
    {
        $delivery = delivery::where('city', $request->city)->first();
        session()->put('fee', $delivery->price);
        return view('public/cart/cart_ajax')->render();
    }
    public function index()
    {
        $delivery = delivery::get();
        $customer = User::where('id', Auth::user()->id)->first();
        return view('public/cart/index')->with(compact('delivery', 'customer'));
    }
    public function store(Request $request)
    {
        $Cart = Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'qty' => $request->quantity,
            'weight' => 0,
            'options' => array(
                'image' => $request->image,
            )
        ]);
    }
    public function update(Request $request, $rowId)
    {
        foreach (Cart::content() as $key => $val) {
            if ($val->rowId == $rowId) {
                $qty = $val->qty;
            }
        }
        if ($request->number == -1) {
            $number = $qty - 1;
        } else {
            $number = $qty + 1;
        }
        Cart::update($rowId, $number);
        if ($number == 0) {
            session()->forget('fee');
        }
        return view('public/cart/cart_ajax')->render();
    }
    function delete(Request $request, $rowId)
    {
        if ($request->ajax()) {
            Cart::remove($rowId);
            session()->forget('fee');
            return view('public/cart/cart_ajax')->render();
        }
    }
}
