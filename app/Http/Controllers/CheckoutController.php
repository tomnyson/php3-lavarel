<?php

namespace App\Http\Controllers;

use App\Models\User;
use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

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
    public function checkout(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'email' => 'required|email',
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
        return view('checkout.index', compact('user', 'carts'));
    }
}
